<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class ProjectType extends Model
{
    protected $guarded = [];
    protected $table = "projects";

    protected static function boot()
    {
        parent::boot();

        static::saved(function (Self $type) {
            static::withoutEvents(function () use ($type) {
                $type->associateType($type);
            });
        });
    }

    public function associateType(Self $type)
    {
        $this->typeable_id = $type->id;
        $this->typeable_type = get_class($type);
        $this->save();
    }

    public function typeable()
    {
        $this->morphTo();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps();
    }
}
