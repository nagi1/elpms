<?php

namespace App\Models\Concerns;

interface Archiveable
{
    public function archive();
    public function unarchive();
    public function archived(): bool;
}
