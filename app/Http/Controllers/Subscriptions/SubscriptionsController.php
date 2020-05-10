<?php

namespace App\Http\Controllers\Subscriptions;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\User;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;
use App\Http\Controllers\Controller;
use App\Actions\Subscribable\UpdateSubscribable;

class SubscriptionsController extends Controller
{
    public function show(Account $account, Project $project, $model, $modelId)
    {
        $model = getModelByType($model, $modelId);
        $modelPresenter = getModelPresenter($model);

        return Inertia::render('Subscriptions/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic')->get(),
            'project' => ProjectsPresenter::make($project->load('subscribers.media'))->only('id', 'name', 'subscribers')->get(),
            'previewCard' => $model->previewCard(),
            'subscribers' => $modelPresenter::make($model->load('subscribers.media'))->preset('subscribers')->get(),
            'breadcrumbs' => [
                'index' => [
                    'link' => $model->indexPath(),
                    'text' => $model->displayName(),
                ],
                'model' => [
                    'link' => $model->path(),
                    'text' => $model->displayField()
                ]
            ]
        ]);
    }


    public function update(Account $account, Project $project, $model, $modelId, Request $request)
    {
        $request->validate([
            'selectedUser' => ['array'],
            'notifyNewPeople' => ['boolean']
        ]);

        $model = getModelByType($model, $modelId);
        $selectedUsers = User::findOrFail($request->selectedUsers);
        app(UpdateSubscribable::class)->execute($model, $selectedUsers, $request->notifyNewPeople);
        return redirect($model->path());
    }
}
