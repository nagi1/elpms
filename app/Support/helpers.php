<?php

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
