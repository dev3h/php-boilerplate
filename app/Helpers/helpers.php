<?php

use App\Core\Validator;

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
     * @param array $params Optional parameters to replace in the URI.
     * @return string|null The URL if found, null otherwise.
     */
    function route(string $name, array $params = []): ?string
    {
        global $router;
        return $router->route($name, $params);
    }
}

if (!function_exists('validator')) {
    /**
     * Validate data against rules.
     *
     * @param array $data The data to validate.
     * @param array $rules The validation rules.
     */
    function validator(array $data, array $rules): Validator
    {
        $validator = new Validator();
        return $validator->validate($data, $rules);
    }
}

if (!function_exists('flash')) {
    /**
     * Flash a message to the session.
     *
     * @param $key The key for the flash message.
     * @param $value The value for the flash message.
     */
    function flash($key, $value = null)
    {
        if (!isset($_SESSION)) session_start();

        if ($value === null) {
            $flash = $_SESSION['_flash'][$key] ?? null;
            unset($_SESSION['_flash'][$key]);
            return $flash;
        }

        $_SESSION['_flash'][$key] = $value;
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value from session.
     *
     * @param string $key The key for the old input.
     * @return mixed|null The old input value or null if not set.
     */
    function old(string $key, $default = '')
    {
        if (!isset($_SESSION)) session_start();

        $old = $_SESSION['_old'][$key] ?? $default;

        unset($_SESSION['_old'][$key]);

        return htmlspecialchars($old, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('set_old')) {
    /**
     * Set old input value in session.
     *
     * @param array $data The data to set as old input.
     */
    function set_old($data)
    {
        if (!isset($_SESSION)) session_start();
        $_SESSION['_old'] = $data;
    }
}

