<?php

namespace App\Core;

class View
{
    /**
     * Renders a view file with the provided data.
     * This method extracts the data array into variables
     * and includes the view file.
     * @param string $view The name of the view file (without .php extension).
     * @param array $data An associative array of data to be passed to the view.
     * @return void
     */
    public static function render(string $view, array $data = [])
    {
        $viewPath = dirname(__DIR__) . '/Views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            echo "View file not found: $viewPath";
            return;
        }

        /**
         * Extracts array elements as individual variables.
         * Example: ['title' => 'Hello'] becomes $title = 'Hello';
         * These variables will be available inside the view file.
         */
        extract($data);
        require_once $viewPath;
    }
}