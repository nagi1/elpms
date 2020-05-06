<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\User;
use App\Models\Boost;

trait HasBoosts
{
    public function getBoostsCount(): int
    {
        return $this->boosts()->count();
    }


    public function updateBoostCountMeta(): void
    {
        $this->meta->set([
            'boosts_count' => $this->getBoostsCount(),
        ]);
        $this->save();
    }

    public function boosts(): MorphMany
    {
        return $this->morphMany(Boost::class, 'boostable');
    }

    public function boost(User $user, array $attributes): Boost
    {
        $boost = $this->boosts()->save(new Boost(array_merge([
            'user_id' => $user->id,
            'boostable_id' => $this->getKey(),
            'boostable_type' => get_class(),
        ], $attributes)));

        $this->updateBoostCountMeta();
        return $boost;
    }
}
