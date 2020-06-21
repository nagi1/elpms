<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Event;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\TodoItem\UpdateTodoItemAction;
use App\Actions\Event\UpdateEventAction;

class EditEventsController extends Controller
{
    public function update(Account $account, Project $project, Event $event, Request $request, UpdateEventAction $updateEventAction)
    {
        $request->validate(['name' => ['required']]);
        $updateEventAction->execute($project, $event, $request->all());
        return redirect()->back();
    }
}
