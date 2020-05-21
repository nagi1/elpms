<?php

namespace App\Models\Concerns;

use \Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use App\Scopes\ArchiveableScope;

trait ArchiveTrait
{

    public function initializeArchiveTrait()
    {
        $this->dates[] = 'archived_at';
    }

    public static function bootArchiveTrait()
    {
        static::addGlobalScope(new ArchiveableScope);
    }

    public function archiveWithoutEvents()
    {
        return static::withoutEvents(function () {
            $this->archive();
        });
    }

    public function unarchiveWithoutEvents()
    {
        return static::withoutEvents(function () {
            $this->unarchive();
        });
    }

    public function archive()
    {
        $this->{$this->getQualifiedArchivedAtColumn()} = Carbon::now();
        $this->save();
        $this->updateArchiveCountMeta();
        $this->fireModelEvent('archived');
    }

    public function unarchive()
    {
        $this->{$this->getQualifiedArchivedAtColumn()} = null;
        $this->save();
        $this->updateArchiveCountMeta();
        $this->fireModelEvent('unarchived');
    }

    public function getArchivedCount(): int
    {
        return $this->onlyArchived()->count();
    }


    public function updateArchiveCountMeta(): void
    {
        $this->meta->set([
            'archived_count' => $this->getArchivedCount(),
        ]);
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
