<?php

require_once __DIR__ . "/vendor/autoload.php";

use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


use App\Core\Database;

$pdo = Database::getInstance()->getConnection();

$pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$command = $argv[1] ?? null;

$migrationFiles = glob(__DIR__ . "/database/migrations/*.php");

if ($command === "up") {
    foreach ($migrationFiles as $file) {
        $migrationName = basename($file);

        // Check if migration has already been applied
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM migrations WHERE migration = ?");
        $stmt->execute([$migrationName]);
        if ($stmt->fetchColumn() > 0) {
            continue;
        }

        $migration = require $file;
        $migration->up($pdo);

        $stmt = $pdo->prepare("INSERT INTO migrations (migration) VALUES (?)");
        $stmt->execute([$migrationName]);
    }
    echo "All migrations applied!\n";
}

if ($command === "down") {
    // rollback latest migration
    $stmt = $pdo->query("SELECT * FROM migrations ORDER BY id DESC LIMIT 1");
    $last = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($last) {
        $file = __DIR__ . "/database/migrations/" . $last['migration'];
        if (file_exists($file)) {
            $migration = require $file;
            $migration->down($pdo);

            $stmt = $pdo->prepare("DELETE FROM migrations WHERE id = ?");
            $stmt->execute([$last['id']]);
        }
    }
    echo "Rolled back last migration!\n";
}

