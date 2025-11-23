<?php

// Laravel built-in server router script
// If the request is for a static file that exists in public/, let the server serve it.
// Otherwise, forward the request to public/index.php.

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

require_once __DIR__.'/public/index.php';