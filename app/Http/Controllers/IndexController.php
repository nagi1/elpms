<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Presenters\ProjectsPresenter;
use App\Models\Account;

class IndexController extends Controller
{
    public function __invoke(Account $account)
    {
        return Inertia::render(
            'Index/Index',
            [
                'account' => $account->only('id', 'name'),
                'projectTypes' => ProjectsPresenter::make(
                    Auth::user()->projects()->get()
                )->get()
            ]
        );
    }
}
