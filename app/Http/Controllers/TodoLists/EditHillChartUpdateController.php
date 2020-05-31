<?php

namespace App\Http\Controllers\TodoLists;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\HillChartUpdate;
use App\Models\Account;
use App\Http\Controllers\Controller;

class EditHillChartUpdateController extends Controller
{

    public function __invoke(Account $account, Project $project, HillChartUpdate $hillChartUpdate, Request $request)
    {
        $hillChartUpdate->update(['notes' => $request->notes]);
        return redirect()->back();
    }
}
