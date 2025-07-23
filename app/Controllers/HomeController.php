<?php
namespace App\Controllers;

use App\Core\Database;
use App\Core\View;

class HomeController
{
    protected $db;
    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index(): void
    {
        $name = 'Hoa';
        View::render('home', ['name' => $name]);
    }
}