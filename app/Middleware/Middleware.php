<?php
declare(strict_types=1);
namespace MyHR\Middleware;

use MyHR\Core\{Auth, Rbac, Csrf, Flash, View};
use MyHR\Core\Request as HttpRequest;
use MyHR\Core\Env;

function auth(HttpRequest $req, ?string $arg): void
{
    if (Env::bool('APP_DEMO')) return;
    if (!Auth::check()) { Flash::warning('Please sign in.'); header('Location: ' . app_url('/login')); exit; }
}

function guest(HttpRequest $req, ?string $arg): void
{
    if (Env::bool('APP_DEMO')) return;
    if (Auth::check()) { header('Location: ' . app_url('/dashboard')); exit; }
}

function permission(HttpRequest $req, ?string $slug): void
{
    if (Env::bool('APP_DEMO')) return;
    if (!Auth::check()) { header('Location: ' . app_url('/login')); exit; }
    if ($slug === null || !Rbac::can($slug)) {
        http_response_code(403);
        echo View::render('errors/403', ['required' => $slug], null);
        exit;
    }
}

function csrf(HttpRequest $req, ?string $arg): void
{
    if (!$req->isPost()) return;
    if (!Csrf::verify($req->input('_token'))) {
        http_response_code(419);
        echo View::render('errors/419', [], null);
        exit;
    }
}