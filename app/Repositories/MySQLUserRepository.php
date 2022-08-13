<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Exceptions\RecordNotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MySQLUserRepository implements UserRepository {

    private Connection $conn;
    public function __construct()
    {
        $connectionParams = $this->connectToDatabase();
        $this->conn = DriverManager::getConnection( $connectionParams );
    }

    private function connectToDatabase(): array{
        return ['dbname' => $_ENV['DBNAME'],
            'user' => $_ENV['USER'],
            'password' => $_ENV['PASSWORD'],
            'host' => $_ENV['HOST'],
            'driver' => $_ENV['DRIVER']
        ];
    }

    public function save(User $user): void
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

    public function getByEmail(string $email): User
    {
        $queryBuilder = $this->conn->createQueryBuilder();
        $user = $queryBuilder->select('*')
            ->from('user')
            ->where('user_email = :email')
            ->setParameter('email', $email)
            ->fetchAssociative();

        if(! $user){
            throw new RecordNotFoundException('user with email' . $email. 'not found');
        }

        return new User(
            $user['user_name'],
            $user['user_email'],
            $user['user_pswd'],
            $user['user_id'],
        );
    }
}