<?php

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell
 */

if (php_sapi_name() == 'cli-server') {
    // To help the built-in PHP server, we need to simulate
    // the behavior of the front controller by mapping requests
    // to the index.php file. This file will handle all the requests
    // and dispatch them to the application.
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    if ($uri !== '/' && file_exists(__DIR__.$uri)) {
        return false;
    }

    require_once __DIR__.'/public/index.php';
} else {
    // All other requests are forwarded to the index.php file.
    require_once __DIR__.'/public/index.php';
}
