<?php

namespace App\Models\Contracts;

interface ArchiveContract
{
    public function archive();
    public function unarchive();
    public function archived(): bool;
}
