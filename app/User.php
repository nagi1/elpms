<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Project;
use App\Models\Pivots\ProjectUsers;
use App\Models\Pivots\AccountUser;
use App\Models\Account;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->using(ProjectUsers::class)
            ->as('projectUsers')
            ->withTimestamps()
            ->with('users');
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
