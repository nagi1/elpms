<?php

use Illuminate\Support\Str;

if (!function_exists('getModelByType')) {
    function getModelByType(string $model, int $id)
    {
        try {
            $model = new ReflectionClass("\\App\\Models\\{$model}");
        } catch (\ReflectionException $e) {
            abort(404);
        }

        $model = $model->getName();
        return $model::find($id);
    }
}


if (!function_exists('getModelPresenter')) {
    function getModelPresenter($model)
    {
        try {

            $presenter = new ReflectionClass("\\App\\Presenters\\" . Str::plural(class_basename($model)) . "Presenter");
        } catch (\ReflectionException $e) {
            abort(404);
        }

        return $presenter->getName();
    }
}
