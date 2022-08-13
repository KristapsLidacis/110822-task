<?php

namespace App\Controllers;

use App\Auth;
use App\Services\LoginService;
use App\Services\LoginServiceRequest;
use App\View;

class LoginController
{

    private LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function showForm(): View
    {
        return new View('login');
    }


    public function auth(): void
    {

        $this->loginService->execute(
            new LoginServiceRequest(
                $_POST['email'],
                $_POST['password']
            )
        );

        header('Location: /');
    }

    public function logout(): void
    {
        Auth::logout();
        header('Location: /');
    }
}