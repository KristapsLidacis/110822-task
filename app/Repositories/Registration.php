<?php

namespace App\Repositories;

use App\Models\UserModel;

interface Registration
{
    public function save(UserModel $user): void;
}