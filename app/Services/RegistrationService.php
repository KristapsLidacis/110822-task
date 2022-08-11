<?php

namespace App\Services;

use App\Models\UserModel;

class RegistrationService
{
    public function execute(RegisterServiceRequest $request): UserModel
    {
        return new UserModel(
            $request->getName(),
            $request->getEmail(),
            $request->getPassword()
        );
    }
}