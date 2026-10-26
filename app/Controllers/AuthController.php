<?php
declare(strict_types=1);
namespace MyHR\Controllers;

use MyHR\Core\{Auth, Csrf, Env, Flash, Request, Validator, View};

final class AuthController
{
    public function showLogin(Request $req): string
    {
        return View::render('auth/login', ['csrf' => Csrf::field()], 'layouts/public');
    }

    public function login(Request $req): string
    {
        if (Env::bool('APP_DEMO')) {
            Flash::success('Signed in (demo mode)');
            header('Location: ' . app_url('/dashboard'));
            exit;
        }

        $v = (new Validator($req->post))
            ->required('email', 'Email')
            ->email('email', 'Email')
            ->required('password', 'Password');

        if ($v->fails()) {
            Flash::error($v->firstError());
            return $this->showLogin($req);
        }

        $result = Auth::attempt($req->str('email'), (string) $req->input('password'), $req);
        if (!$result['ok']) {
            Flash::error($result['reason'] ?? 'Unable to sign in.');
            return $this->showLogin($req);
        }

        header('Location: ' . app_url('/dashboard'));
        exit;
    }

    public function logout(Request $req): void
    {
        Auth::logout();
        header('Location: ' . app_url('/login'));
        exit;
    }
}