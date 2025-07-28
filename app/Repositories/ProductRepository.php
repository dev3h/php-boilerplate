<?php

namespace App\Repositories;

use App\Core\Database;
use PDO;
use PDOException;

class ProductRepository
{
    protected $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get_all()
    {
       try {
            $stmt = $this->db->query("SELECT * FROM products");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching products: " . $e->getMessage();
            return [];
        }
    }
}