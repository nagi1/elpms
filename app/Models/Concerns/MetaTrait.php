<?php

namespace App\Models\Concerns;

use Spatie\SchemalessAttributes\SchemalessAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait MetaTrait
{

    public function initializeMetaTrait()
    {
        $this->casts = array_merge($this->casts, ['meta' => 'array']);
    }

    public function getMetaAttribute(): SchemalessAttributes
    {
        return SchemalessAttributes::createForModel($this, 'meta');
    }

    public function scopeWithMeta(): Builder
    {
        return SchemalessAttributes::scopeWithSchemalessAttributes('meta');
    }
}
