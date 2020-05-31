<?php

namespace App\Actions\HillChart;

use Auth;
use App\User;
use App\Models\TodoList;
use App\Models\Project;

class UpdateHillChartAction
{
    /**
     * Create a new action instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Prepare the action for execution, leveraging constructor injection.
    }

    /**
     * Execute the action.
     *
     * @return mixed
     */
    public function execute(Project $project, array $data, ?string $notes = null, User $user = null)
    {
        if (is_null($user)) {
            $user = Auth::user();
        }

        $dataCollection = collect($data);

        $dataCollection->each(function ($point) {
            TodoList::find($point['id'])->updateHillChartPoint($point);
        });

        $project->hillChartUpdates()->create([
            'data' => json_encode($data),
            'notes' => $notes,
            'user_id' => $user->id
        ]);
    }
}
