<?php

namespace App\Actions\TodoItem;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use App\User;

class AbstractTodoItemAction
{
    protected array $attributes;
    protected User $user;
    protected array $preparedAttributes = [];

    protected function __construct(array $attributes, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }


        $this->attributes = $attributes;
        $this->user = $user;
    }

    protected function prepareUsers(?string $userString = null): Collection
    {
        if (is_null($userString)) {
            return collect();
        }

        return User::findOrFail(explode(',', $userString));
    }

    protected function mergeUser()
    {
        $this->preparedAttributes = array_merge($this->preparedAttributes, ['user_id' => $this->user->id]);
    }

    protected function prepareDate(?string $date = "")
    {

        if (empty($date)) {
            $this->preparedAttributes = array_merge($this->preparedAttributes, [
                'starts_at' => null,
                'ends_at' => null,
            ]);
            return;
        }

        $dates = explode(',', $date);

        $this->preparedAttributes = array_merge($this->preparedAttributes, [
            'starts_at' => $this->multipleDates($dates) ? Carbon::parse($dates[0]) : null,
            'ends_at' => $this->multipleDates($dates) ? Carbon::parse($dates[1]) : Carbon::parse($dates[0])
        ]);
    }


    protected function multipleDates(array $dates)
    {
        return count($dates) > 1;
    }

    protected function prepareAttributes()
    {
        $this->mergeUser();
        $this->prepareDate($this->attributes['dueOn']);

        $this->preparedAttributes = array_merge($this->preparedAttributes, [
            'description' => $this->attributes['description'],
            'todoitem-trixFields' => $this->attributes['todoitem-trixFields'],
            'attachment-todoitem-trixFields' => $this->attributes['attachment-todoitem-trixFields'],
        ]);
    }
}
