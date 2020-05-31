<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Auth;
use App\User;
use App\Models\ChangeEvent;
use App\Models\Boost;

trait ChangeEventTrait
{

    public function changeEvents(): MorphMany
    {
        return $this->morphMany(ChangeEvent::class, 'changeable')->orderByDesc('created_at');
    }

    public function userDid(array $attributes, User $user): ChangeEvent
    {
        return $this->changeEvents()->save(new ChangeEvent(array_merge([
            'user_id' => $user->id,
            'changeable_id' => $this->getKey(),
            'changeable_type' => get_class(),
        ], $attributes)));
    }
}
