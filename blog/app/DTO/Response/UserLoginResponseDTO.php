<?php

namespace App\DTO\Response;

use App\Models\User;

class UserLoginResponseDTo
{
    public $token;
    public $username;
    public $userId;

    public function __construct(string $token, User $user)
    {
        $this->token = $token;
        $this->username = $user->username;
        $this->userId = $user->id;
    }

    public function toArray()
    {
        return [
            'token' => $this->token,
            'username' => $this->username,
            'userId' => $this->userId,
        ];
    }
}