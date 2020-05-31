<?php

namespace App\Models\Concerns;


trait HillChartTrait
{
    public static function bootHillChartTrait()
    {
        static::deleted(function () {
            $this->disableHillChartPoint();
        });
    }

    public function disableHillChartPoint()
    {
        $this->meta->set(['hillChartPoint.enabled' => false]);
        $this->save();
    }

    public function enableHillChartPoint()
    {
        $this->meta->set(['hillChartPoint.enabled' => true]);
        $this->save();
    }

    public function hasBeenEnabled(): bool
    {
        return (bool) $this->meta->get('hillChartPoint.id');
    }

    public function setHillChartPoint()
    {
        $this->meta->set(['hillChartPoint' => [
            'id' => $this->id,
            'description' => $this->name,
            'enabled' => true,
            'color' => $this->color,
            'size' => 10,
            'x' => 0,
            'y' => 0,
            'link' => $this->path()
        ]]);

        $this->save();
    }

    public function updateHillChartPoint(array $attributes)
    {
        $enabled = $this->meta->get('hillChartPoint.enabled', false);
        // $this->meta->hillChartPoint = null;
        // $this->save();
        // dump($this->meta->get('hillChartPoint'));

        if ($enabled) {
            $this->meta->hillChartPoint = array_merge($attributes, ['enabled' => true]);
            $this->save();
            // dump($this->meta->get('hillChartPoint'));
        }
    }
}
