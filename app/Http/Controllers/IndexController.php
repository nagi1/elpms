<?php

namespace App\Http\Controllers;

use Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Account;
use App\Actions\User\GenerateAvatarFromNameAction;

class IndexController extends Controller
{
    public function __invoke(Account $account)
    {
        // dd(ProjectsPresenter::make(
        //     Auth::user()->projects()->with(['users'])->get()
        // )->except('categories')->get());
        return Inertia::render(
            'Index/Index',
            [
                'account' => AccountsPresenter::make($account)->preset('basic'),
                'projectTypes' => ProjectsPresenter::make(
                    Auth::user()->projects()->with(['users'])->get()
                )->except('categories')->get()
            ]
        );
    }
}
