<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Project;
use App\Models\Account;

class SubscriptionController extends Controller
{
    public function show(Account $account, Project $project, $model, $modelId)
    {
        $model = getModelByType($model, $modelId);
        $modelPresenter = getModelPresenter($model);

        return Inertia::render('Subscriptions/Show', [
            'account' => AccountsPresenter::make($account)->preset('basic'),
            'project' => ProjectsPresenter::make($project->load('subscribers.media'))->only('id', 'name', 'subscribers'),
            'previewCard' => $model->previewCard(),
            'subscribers' => $modelPresenter::make($model->load('subscribers.media'))->preset('subscribers'),
            'breadcrumps' => [
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
}
