<?php

namespace App\Services;

use App\Auth;
use App\Repositories\Exceptions\RecordNotFoundException;
use App\Repositories\MySQLUserRepository;
use App\Services\LoginServiceRequest;

class LoginService
{
    private MySQLUserRepository $mySQLUserRepository;

    public function __construct(MySQLUserRepository $mySQLUserRepository)
    {

        $this->mySQLUserRepository = $mySQLUserRepository;
    }

    public function execute(LoginServiceRequest $request): void
    {
        try {
            $user = $this->mySQLUserRepository->getByEmail($request->getEmail());
            if(! password_verify($request->getPassword(), $user->getPassword()))
            {
               var_dump('error');die;
            }

            Auth::authorize($user->getId());
        } catch (RecordNotFoundException) {

        }
    }
}