<?php

namespace App\DTO\Request;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserLoginRequestDTO
{
    private $userId;
    private $password;

    public function __construct(Request $request)
    {
        $this->userId = $request->userId;
        $this->password = $request->password;
    }

    public function validate()
    {
        $data = [
            'userId' => $this->userId,
            'password' => $this->password,
        ];

        return validator($data, [
            'userId' => 'required|string',
            'password' => 'required|string',
        ])->validate();
    }

    public function getCredentials()
    {
        return [
            'userId' => $this->userId,
            'password' => $this->password,
        ];
    }
}