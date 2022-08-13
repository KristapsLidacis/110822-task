<?php

namespace App\Controllers;

use App\Repositories\MySQLUserRepository;
use App\Services\RegisterServiceRequest;
use App\Services\RegisterService;
use App\Services\ValidationService;
use App\View;

class RegisterController
{

    private RegisterService $registrationService;

    public function __construct(RegisterService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function showForm(): View
    {
        return new View('register');
    }

    public function store():void
    {
        $userName = $_POST['name'];
        $userEmail = $_POST['email'];
        $password = $_POST['password'];
        $password_conf = $_POST['password_confirmation'];

        $validate = new RegistrationValidationController(new ValidationService(new MySQLUserRepository()));

        if(! $validate->isRegistered($userEmail)){
            if (filter_var($userEmail, FILTER_VALIDATE_EMAIL) && strlen($password) >= 8 && $password = $password_conf) {
                $this->registrationService->execute(new RegisterServiceRequest($userName,$userEmail, $password));
            }
        }else{
            var_dump("already exists");die;
        }

        header('Location: /login');
    }
}