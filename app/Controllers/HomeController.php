<?php
namespace App\Controllers;

use App\Core\View;

class HomeController
{
    public function index(): void
    {
        $name = 'Hoa';
        View::render('home', ['name' => $name]);
    }
}