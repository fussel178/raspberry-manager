<?php

function app_dir(): string
{
    return base_dir() . 'app/';
}

function base_dir(): string
{
    return __DIR__ . '/../';
}

function require_once_all(string $dir)
{
    foreach (glob($dir . '*.php') as $fileName) {
        require_once $fileName;
    }
}

function render_view(string $view, array $values = array())
{
    $filePath = app_dir() . 'views/' . $view . '.php';
    $output = NULL;
    if (file_exists($filePath)) {
        // Extract the variables to a local namespace
        extract($values);

        // Start output buffering
        ob_start();

        // Include the template file
        include $filePath;

        // End buffering and return its contents
        $output = ob_get_clean();
    }

    return $output;
}

function render_element(string $name, array $values = array())
{
    return render_view('elements/' . $name, $values);
}

function extract_from(array $source, array $keys): array {
    $extracted = array();
    foreach ($keys as $key) {
        $extracted[$key] = $source[$key] ?? NULL;
    }
    return $extracted;
}
