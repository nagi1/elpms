<?php

namespace App\Actions;

use App\Models\Contracts\BucketContract;

class BucketPreviewCardAction
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
    public function execute(BucketContract $model)
    {
        $modelPresenter = getModelPresenter($model);
    }
}
