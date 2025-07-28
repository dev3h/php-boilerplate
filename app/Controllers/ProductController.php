<?php

namespace App\Controllers;

use App\Core\View;
use App\Services\ProductService;

class ProductController
{
    protected ProductService $productService;
    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function index()
    {
        $products = $this->productService->get_all();
        View::render('product/index', ['products' => $products]);
    }
}