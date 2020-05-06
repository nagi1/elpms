<?php

namespace App\Actions\User;

use Spatie\QueueableAction\QueueableAction;
use App\User;

class GenerateAvatarFromNameAction
{
    use QueueableAction;

    public function __construct()
    {
    }

    public function execute(User $user): void
    {
        $avatar = \Avatar::create($user->name)->toBase64();
        $user->addMediaFromBase64($avatar->encoded, 'image/png')
            ->usingFileName('avatar.png')
            ->toMediaCollection('avatar');
    }
}
