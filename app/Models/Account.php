<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Project;
use App\Models\Pivots\AccountUser;
use App\Models\Category;

class Account extends Model
{
    protected $guarded = [];
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,)
            ->using(AccountUser::class)
            ->as('accountUsers')
            ->withTimestamps();
    }

    public function admins()
    {
        return $this->users()->withPivotValue('role', 'admin');
    }

    public function owners()
    {
        return $this->users()->withPivotValue('role', 'owner');
    }

    public function member()
    {
        return $this->users()->withPivotValue('role', 'member');
    }
}
