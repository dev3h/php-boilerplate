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

    public function get_one(int $id): ?array
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
            if ($stmt->rowCount() === 0) {
                return null;
            }
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching product: " . $e->getMessage();
            return null;
        }
    }

    public function store(array $data): array
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO products (name, price) VALUES (:name, :price)");
            $stmt->execute([
                ':name' => $data['name'],
                ':price' => $data['price']
            ]);
            return ['status' => '201', 'message' => 'Product created successfully'];
        } catch (PDOException $e) {
            echo "Error storing product: " . $e->getMessage();
            return ['status' => '500', 'message' => 'Internal Server Error'];
        }
    }

    public function update(array $data): array
    {
        try {
            $stmt = $this->db->prepare("UPDATE products SET name = :name, price = :price WHERE id = :id");
            $stmt->execute([
                ':id' => $data['id'],
                ':name' => $data['name'],
                ':price' => $data['price']
            ]);
            return ['status' => '200', 'message' => 'Product updated successfully'];
        } catch (PDOException $e) {
            echo "Error updating product: " . $e->getMessage();
            return ['status' => '500', 'message' => 'Internal Server Error'];
        }
    }

    public function delete(int $id): void
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            echo "Error deleting product: " . $e->getMessage();
        }
    }
}