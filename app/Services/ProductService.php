<?php

namespace App\Services;

use App\Repositories\ProductRepository;

class ProductService
{
    protected ProductRepository $productRepository;
    public function __construct()
    {
        $this->productRepository = new ProductRepository();
    }

    public function get_all()
    {
        return $this->productRepository->get_all();
    }
}