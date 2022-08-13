<?php

namespace App\Repositories;

use App\Models\User;

interface UserRepository
{
    public function getByEmail(string $email): User;
    public function save(User $user): void;
}