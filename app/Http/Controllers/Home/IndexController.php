<?php

namespace App\Http\Controllers\Home;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Presenters\ProjectsPresenter;
use App\Presenters\AccountsPresenter;
use App\Models\Account;
use App\Http\Controllers\Controller;


class IndexController extends Controller
{
    public function __invoke(Account $account)
    {
        session(['account_id' => $account->id]);
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
