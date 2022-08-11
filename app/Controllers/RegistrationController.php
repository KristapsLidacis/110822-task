<?php

namespace App\Controllers;

use App\Services\RegisterServiceRequest;
use App\Services\RegistrationService;
use App\View;

class RegistrationController
{

    private RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function showForm(): View
    {
        return new View('register.twig');
    }

    public function store(): View
    {
        $this->registrationService->execute(new RegisterServiceRequest($_POST['name'], $_POST['email'], $_POST['password']));
        return new View('register.twig');
    }
}