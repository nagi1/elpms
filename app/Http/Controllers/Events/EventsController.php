<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Event\CreateEventAction;

class EventsController extends Controller
{
    public function store(Account $account, Project $project, Request $request, CreateEventAction $createEventAction)
    {
        $request->validate(['name' => ['required']]);
        $createEventAction->execute($project, $request->all());

        return redirect()->back();
    }
}
