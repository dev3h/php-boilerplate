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

    public function index(): void
    {
        $products = $this->productService->get_all();
        View::render('product/index', ['products' => $products]);
    }

    public function create(): void
    {
        View::render('product/create');
    }

    public function store()
    {
        $result = $this->productService->store($_POST);
        if (isset($result['status']) && $result['status'] === '422') {
            flash('errors', $result['errors']);
            set_old($_POST);
            header('Location: /product/create');
            exit;
        } else {
            // Redirect to product index or show success message
            header('Location: /product');
            exit;
        }
    }
}