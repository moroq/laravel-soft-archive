<?php

namespace Illuminate\Database\Eloquent;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait SoftArchives
{
    /**
     * Boot the soft archiving trait for a model.
     *
     * @return void
     */
    public static function bootSoftArchives()
    {
        static::addGlobalScope(new SoftArchivingScope);
    }

    /**
     * Perform the actual archive query on this model instance.
     *
     * @return mixed
     */
    protected function performArchiveOnModel()
    {
        return $this->runSoftArchive();
    }

    /**
     * Perform the actual archive query on this model instance.
     *
     * @return void
     */
    protected function runSoftArchive()
    {
        $query = $this->newModelQuery()->where($this->getKeyName(), $this->getKey());

        $time = $this->freshTimestamp();

        $columns = [
        	$this->getArchivedAtColumn() => $this->fromDateTime($time),
        	$this->getArchivedByColumn() => Auth::id()
        ];

        $this->{$this->getArchivedAtColumn()} = $time;

        if ($this->timestamps && ! is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        $query->update($columns);
    }

    /**
     * Archive a soft-archived model instance.
     *
     * @return bool|null
     *
     * @throws \Exception
     */
    public function archive()
    {


        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('archiving') === false) {
            return false;
        }

        $this->{$this->getArchivedAtColumn()} = Carbon::now();
        $this->{$this->getArchivedByColumn()} = Auth::id();

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('archived', false);

        return $result;
    }

    /**
     * Unarchive a soft-archived model instance.
     *
     * @return bool|null
     */
    public function unarchive()
    {
        // If the restoring event does not return false, we will proceed with this
        // restore operation. Otherwise, we bail out so the developer will stop
        // the restore totally. We will clear the deleted timestamp and save.
        if ($this->fireModelEvent('unarchiving') === false) {
            return false;
        }

        $this->{$this->getArchivedAtColumn()} = null;
        $this->{$this->getArchivedByColumn()} = null;

        // Once we have saved the model, we will fire the "restored" event so this
        // developer will do anything they need to after a restore operation is
        // totally finished. Then we will return the result of the save call.
        $this->exists = true;

        $result = $this->save();

        $this->fireModelEvent('archived', false);

        return $result;
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function isArchived()
    {
        return ! is_null($this->{$this->getArchivedAtColumn()});
    }

    /**
     * Register a restoring model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function unarchiving($callback)
    {
        static::registerModelEvent('unarchiving', $callback);
    }

    /**
     * Register a restored model event with the dispatcher.
     *
     * @param  \Closure|string  $callback
     * @return void
     */
    public static function archived($callback)
    {
        static::registerModelEvent('archived', $callback);
    }

    /**
     * Get the name of the "deleted at" column.
     *
     * @return string
     */
    public function getArchivedAtColumn()
    {
        return defined('static::ARCHIVED_AT') ? static::ARCHIVED_AT : 'archived_at';
    }

    /**
     * Get the name of the "deleted by" column.
     *
     * @return string
     */
    public function getArchivedByColumn()
    {
        return defined('static::ARCHIVED_BY') ? static::ARCHIVED_BY : 'archived_by';
    }

    /**
     * Get the fully qualified "deleted at" column.
     *
     * @return string
     */
    public function getQualifiedArchivedAtColumn()
    {
        return $this->qualifyColumn($this->getArchivedAtColumn());
    }

    /**
     * Get the fully qualified "deleted by" column.
     *
     * @return string
     */
    public function getQualifiedArchivedByColumn()
    {
        return $this->qualifyColumn($this->getArchivedByColumn());
    }
}
