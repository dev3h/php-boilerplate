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

    public function get_all(): ?array
    {
       try {
            $stmt = $this->db->query("SELECT * FROM products ORDER BY id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching products: " . $e->getMessage();
            return [];
        }
    }

    public function store(array $data): array
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
            $stmt->bindParam(':name', $data['name']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->execute();
            return ['status' => '201', 'message' => 'Product created successfully'];
        } catch (PDOException $e) {
            echo "Error storing product: " . $e->getMessage();
            return ['status' => '500', 'message' => 'Internal Server Error'];
        }
    }
}