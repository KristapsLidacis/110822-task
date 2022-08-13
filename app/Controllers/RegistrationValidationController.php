<?php

namespace App\Controllers;

use App\Repositories\MySQLUserRepository;
use App\Services\ValidationService;

class RegistrationValidationController{


    private ValidationService $validationService;

    public function __construct(ValidationService $validationService)
    {

        $this->validationService = $validationService;
    }

    public function isRegistered(string $email):bool{

         return $this->validationService->checkEmail($email);
    }

}