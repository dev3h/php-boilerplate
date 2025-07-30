<?php

if (!function_exists('dd')) {
    /**
     * Dump and die function for debugging with pretty output.
     *
     * @param mixed ...$args
     */
    function dd(...$args): void
    {
        echo '<pre style="background:#222;color:#fff;padding:10px;border-radius:6px;font-size:14px;">';
        foreach ($args as $arg) {
            print_r($arg);
            echo "\n";
        }
        echo '</pre>';
        die;
    }
}

if (!function_exists('route')) {
    /**
     * Generate a URL for a named route.
     *
     * @param string $name The name of the route.
     * @return string|null The URL if found, null otherwise.
     */
    function route(string $name): ?string
    {
        global $router;
        return $router->route($name);
    }
}