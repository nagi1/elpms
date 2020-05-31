<?php

namespace App\Http\Controllers\TodoLists;

use Inertia\Inertia;
use App\Presenters\ProjectsPresenter;
use App\Presenters\HillChartUpdatesPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\HillChartUpdate;
use App\Models\Comment;
use App\Models\Account;
use App\Http\Controllers\Controller;

class ShowHillChartUpdateController extends Controller
{
    public function __invoke(Account $account, Project $project, HillChartUpdate $hillChartUpdate)
    {
        return Inertia::render('TodoLists/HillChart/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load(['users.media']))->only('id', 'name', 'users')->get(),
            'update' => HillChartUpdatesPresenter::make($hillChartUpdate->load(['user.media', 'comments.user.media', 'comments.boosts.user.media', 'comments.trixRichText', 'boosts.user.media', 'subscribers.media']))->get(),
            'commentsTrix' => trixEditorForModel(Comment::class),
        ]);
    }
}
