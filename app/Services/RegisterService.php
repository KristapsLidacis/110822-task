<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\MySQLUserRepository;

class RegisterService
{
    private MySQLUserRepository $registrationRepository;

    public function __construct(MySQLUserRepository $registrationRepository)
    {
        $this->registrationRepository = $registrationRepository;
    }

    public function execute(RegisterServiceRequest $request): User
    {
      $user = new User(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );

      $this->registrationRepository->save($user);
      return $user;
    }
}