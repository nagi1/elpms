<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
use App\Models\MessageBoard;

class Category extends Model
{
    protected $guarded = [];

    public function getFullNameAttribute()
    {
        return "{$this->icon} {$this->name}";
    }

    public function messageBoards()
    {
        return $this->hasMany(MessageBoard::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
