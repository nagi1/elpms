<?php

namespace App\Http\Controllers\TodoLists;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\HillChartUpdatesPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\TodoList;
use App\Models\Project;
use App\Models\HillChartUpdate;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\HillChart\UpdateHillChartAction;
use App\Actions\HillChart\EnableHillChartAction;

class HillChartController extends Controller
{
    public function update(Account $account, Project $project, Request $request, EnableHillChartAction $enableHillChartAction)
    {
        $request->validate([
            'selectedTodoLists' => ['array'],
        ]);

        $selectedTodoLists = TodoList::findOrFail($request->selectedTodoLists);

        if (!$enableHillChartAction->execute($project, $selectedTodoLists)) {
            return redirect()->back()->with('success', 'The Hill Chart has been turned off
');
        }

        return redirect()->back();
    }

    public function store(Account $account, Project $project, Request $request, UpdateHillChartAction $updateHillChartAction)
    {
        $request->validate([
            'data' => ['array'],
        ]);

        $updateHillChartAction->execute($project, $request->data, $request->notes);

        return redirect()->back();
    }

    public function destroy(Account $account, Project $project, HillChartUpdate $hillChartUpdate)
    {
        $hillChartUpdate->delete();
        return redirect()->back();
    }

    public function index(Account $account, Project $project)
    {
        return Inertia::render('TodoLists/HillChart/Updates', [
            'account' => AccountsPresenter::make($account)->preset('basic'),
            'project' => ProjectsPresenter::make($project)->preset('basic'),
            'updates' => HillChartUpdatesPresenter::collection($project->hillChartUpdates()->with(['user.media', 'boosts.user.media'])->latest()->get())->get(),
        ]);
    }
}
