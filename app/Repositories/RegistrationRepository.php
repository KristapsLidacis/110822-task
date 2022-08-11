<?php

namespace App\Repositories;

use App\Models\UserModel;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class RegistrationRepository implements Registration {

    private array $connectionParams;
    private Connection $conn;
    public function __construct()
    {
        $this->connectionParams = $this->connectToDatabase();
        $this->conn = DriverManager::getConnection( $this->connectionParams );
    }

    private function connectToDatabase(): array{
        return ['dbname' => $_ENV['DBNAME'],
            'user' => $_ENV['USER'],
            'password' => $_ENV['PASSWORD'],
            'host' => $_ENV['HOST'],
            'driver' => $_ENV['DRIVER']];
    }

    public function save(UserModel $user): void
    {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder->insert('user')
            ->values([
                'user_name' => '?',
                'user_email' => '?',
                'user_pswd' => '?',
            ])
            ->setParameter(0, $user->getName())
            ->setParameter(1, $user->getEmail())
            ->setParameter(2, password_hash($user->getPassword(), PASSWORD_DEFAULT));
        $queryBuilder->executeQuery();
    }
}