<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Auth;
use App\User;
use App\Models\Event;
use App\Models\Boost;

trait EventTrait
{

    public function events(): MorphMany
    {
        return $this->morphMany(Event::class, 'eventable')->orderByDesc('created_at');
    }

    public function userDid(array $attributes, User $user): Event
    {
        return $this->events()->save(new Event(array_merge([
            'user_id' => $user->id,
            'eventable_id' => $this->getKey(),
            'eventable_type' => get_class(),
        ], $attributes)));
    }
}
