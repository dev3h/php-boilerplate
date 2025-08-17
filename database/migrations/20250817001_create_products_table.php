<?php

return new class {
    public function up($pdo)
    {
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        $pdo->exec($sql);
        echo "Created products table\n";
    }

    public function down($pdo)
    {
        $pdo->exec("DROP TABLE IF EXISTS products");
        echo "Dropped products table\n";
    }
};
