<?php

use Te7aHoudini\LaravelTrix\LaravelTrix;
use Recurr\Transformer\ArrayTransformerConfig;
use Recurr\Rule;
use Recurr\RecurrenceCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

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


if (!function_exists('excerpt')) {
    function excerpt(?string $string = "", int $limit = 100, string $end = ""): string
    {
        return Str::limit(strip_tags($string), $limit, $end);
    }
}


if (!function_exists('trixEditorForModel')) {
    function trixEditorForModel($model, $field = 'content')
    {
        return (new LaravelTrix)->make($model, $field, ['id' => 'trix-input', 'containerElement' => 'div'])->__toString();
    }
}


if (!function_exists('shortDate')) {
    function shortDate(?Carbon $date = null): string
    {
        if (is_null($date)) {
            return '';
        }

        if ($date->isToday()) {
            return $date->diffForHumans();
        }

        if ($date->isCurrentYear()) {
            return $date->format('M j, g:ia');
        }

        return $date->format('M j, Y g:ia');
    }
}

if (!function_exists('dayFormat')) {
    function dayFormat(Carbon $date)
    {
        if ($date->isToday()) {
            return 'Today';
        }

        if ($date->isYesterday()) {
            return 'Yesterday';
        }

        if ($date->isCurrentYear()) {
            return $date->format('D, j M');
        }

        return $date->format('D, j M, Y');
    }
}

if (!function_exists('strToBool')) {
    function strToBool(?string $string = ""): bool
    {
        $falsy = ['false', '', '0', 'off', 'no', null];
        return empty($string) || in_array($string, $falsy) ? false : true;
    }
}

if (!function_exists('ruleToEvents')) {
    function ruleToEvents($rule, int $limit = 300): RecurrenceCollection
    {
        $config = new ArrayTransformerConfig;
        $config->enableLastDayOfMonthFix();
        $config->setVirtualLimit($limit);
        $transformer = new \Recurr\Transformer\ArrayTransformer($config);
        return $transformer->transform(
            $rule instanceof Rule ? $rule : (new Rule)->createFromString($rule)
        );
    }
}

if (!function_exists('strToArray')) {
    function strToArray(?string $string = ""): array
    {
        return empty($string) ? [] : explode(',', $string);
    }
}
