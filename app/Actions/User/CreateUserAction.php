<?php

namespace App\Actions\User;

use App\User;

class CreateUserAction
{
    private $generateAvatarFromNameAction;

    public function __construct(GenerateAvatarFromNameAction $generateAvatarFromNameAction)
    {
        $this->generateAvatarFromNameAction = $generateAvatarFromNameAction;
    }

    public function execute(array $attributes): User
    {
        $user = User::create($attributes);
        $this->generateAvatarFromNameAction->onQueue('generate-avatars')->execute($user);
        return $user;
    }
}
