<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class ChooseAccountController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Index/ChooseAccount', [
            'accounts' => auth()->user()->accounts->map(function ($account) {
                return [
                    'id' => $account->id,
                    'name' => $account->name,
                ];
            }),
        ]);
    }
}
