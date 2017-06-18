<?php
require __DIR__ . "/../vendor/autoload.php";

try {
    \josegonzalez\Dotenv\Loader::load([
        'filepath' => dirname(__DIR__) . '/tests/' . '.env',
        'putenv' => true
    ]);
} catch (InvalidArgumentException $e) {
    // do nothing in case the file doesn't exist
}
