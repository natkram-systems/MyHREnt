<?php
declare(strict_types=1);

use MyHR\Core\{Env, Database, Request, Router, Session, View};
use MyHR\Controllers\{AuthController, DemoController};

define('MYHR_ROOT', dirname(__DIR__));
require MYHR_ROOT . '/vendor/autoload.php';
require MYHR_ROOT . '/app/helpers.php';

Env::load(MYHR_ROOT);

$debug = Env::bool('APP_DEBUG');
set_exception_handler(function (Throwable $e) use ($debug) {
    $ref = strtoupper(bin2hex(random_bytes(4)));
    error_log("[MyHR][$ref] " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    if ($debug) {
        echo '<pre style="padding:2rem;font:13px monospace">'
           . htmlspecialchars($e->getMessage() . "\n\n" . $e->getTraceAsString()) . '</pre>';
        return;
    }
    echo View::render('errors/500', ['ref' => $ref], null);
});

if (!Env::bool('APP_DEMO')) Database::boot();

Session::start();
header('X-Frame-Options: DENY');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: same-origin');

$router = new Router();
$router->alias('auth', 'MyHR\\Middleware\\auth');
$router->alias('guest', 'MyHR\\Middleware\\guest');
$router->alias('permission', 'MyHR\\Middleware\\permission');
$router->alias('csrf', 'MyHR\\Middleware\\csrf');

require MYHR_ROOT . '/routes/web.php';

$router->dispatch(Request::capture());