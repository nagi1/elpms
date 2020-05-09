<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface BucketContract
{

    public function displayName(): string;
    public function displayField(): string;
    public function project(): BelongsTo;
    public function user(): BelongsTo;
    public function previewCard(): array;
    public function path(): string;
    public function indexPath(): string;
}
