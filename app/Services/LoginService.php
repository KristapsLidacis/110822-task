<?php

namespace App\Service;

class LoginService
{
    private LoginUserRepository $loginUserRepository;

    public function __construct(LoginUserRepository $loginUserRepository)
    {
        $this->loginUserRepository = $loginUserRepository;
    }

    public function execute()
    {

    }
}