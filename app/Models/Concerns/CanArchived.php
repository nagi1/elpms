<?php

namespace App\Models\Concerns;

use \Carbon\Carbon;
use App\Scopes\ArchiveableScope;

trait CanArchived
{

    public function initializeCanArchived()
    {
        $this->dates[] = 'archived_at';
    }

    public static function bootCanArchived()
    {

        static::addGlobalScope(new ArchiveableScope);
    }

    public function archive()
    {
        $this->{$this->getQualifiedArchivedAtColumn()} = Carbon::now();
        $this->save();
    }

    public function unarchive()
    {
        $this->{$this->getQualifiedArchivedAtColumn()} = null;
        $this->save();
    }

    /**
     * Determine if the model instance has been archived.
     *
     * @return bool
     */
    public function archived(): bool
    {
        return !is_null($this->{$this->getArchivedAtColumn()});
    }

    /**
     * Get the fully qualified "archived at" column.
     *
     * @return string
     */
    public function getQualifiedArchivedAtColumn()
    {
        return $this->getTable() . '.' . $this->getArchivedAtColumn();
    }

    /**
     * Get the name of the "archived at" column.
     *
     * @return string
     */
    public function getArchivedAtColumn()
    {
        return 'archived_at';
    }
}
