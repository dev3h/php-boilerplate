<?php

namespace App\Services;

use App\Core\Validator;
use App\Repositories\ProductRepository;

class ProductService
{
    protected ProductRepository $productRepository;
    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function get_all(): array|null
    {
        return $this->productRepository->get_all();
    }

    public function get_one(int $id): array|null
    {
        return $this->productRepository->get_one($id);
    }

    public function store(array $data)
    {
        $validation = validator($data, [
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:0',
        ]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            return [
                'status' => '422',
                'errors' => $errors,
            ];
        }
        return $this->productRepository->store($data);
    }

    public function update(array $data)
    {
        $validation = validator($data, [
            'id' => 'required|numeric',
            'name' => 'required|min:3',
            'price' => 'required|numeric|min:0',
        ]);
        if ($validation->fails()) {
            $errors = $validation->errors();
            return [
                'status' => '422',
                'errors' => $errors,
            ];
        }
        // Assuming there's an update method in ProductRepository
        return $this->productRepository->update($data);
    }

    public function delete(int $id): void
    {
        $this->productRepository->delete($id);
    }
}