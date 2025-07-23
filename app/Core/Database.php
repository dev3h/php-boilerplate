<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
     /**
     *  Ensures only one database connection exists (Singleton Pattern).
     *
     * @var Database|null
     */
    private static $instance = null;
    private $conn;

    private function __construct()
    {
        $config = require __DIR__ . '/../../config/database.php';
        try {
            $this->conn = new PDO("mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8", $config['user'], $config['pass']);
        
         // Set error mode to throw exceptions for better error handling
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }

    public static function getInstance(): Database|null
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}