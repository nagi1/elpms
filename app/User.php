<?php

namespace App;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;
use Overtrue\LaravelSubscribe\Traits\Subscriber;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Scopes\User\MediaScope;
use App\Models\Project;
use App\Models\Pivots\ProjectUser;
use App\Models\Pivots\AccountUser;
use App\Models\Account;

class User extends Authenticatable implements HasMedia
{

    use Notifiable;
    use InteractsWithMedia;
    use Subscriber;


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = [];


    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();

        $this->addMediaConversion('size-64')
            ->keepOriginalImageFormat()
            ->width(64)
            ->height(64)
            ->performOnCollections('avatar');

        $this->addMediaConversion('size-150')
            ->keepOriginalImageFormat()
            ->width(150)
            ->height(150)
            ->performOnCollections('avatar');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->using(ProjectUser::class)
            ->as('projectUsers')
            ->withTimestamps();
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class)
            ->using(AccountUser::class)
            ->as('accountUsers')
            ->withTimestamps()
            ->with('users');
    }
}
