<?php
namespace App\Services;

use App\Repositories\Exceptions\RecordNotFoundException;
use App\Repositories\MySQLUserRepository;

class ValidationService{
    //visas fumkcijas par validāciju
    private MySQLUserRepository $mySQLUserRepository;

    public function __construct(MySQLUserRepository $mySQLUserRepository)
    {
        $this->mySQLUserRepository = $mySQLUserRepository;
    }

    public function checkEmail(string $email): bool
    {
       try{
           $this->mySQLUserRepository->getByEmail($email);
       }catch (RecordNotFoundException){
            return false;
       }
       return true;
    }
}