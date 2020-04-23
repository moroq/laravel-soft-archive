<?php

namespace Moroq\LaravelSoftArchive\Providers;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class ArchiveServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Blueprint::macro('softArchives', function() {
            $this->timestamp('archived_at', 0)->nullable();
            $this->integer('archived_by', 0)->nullable();
        });

        Blueprint::macro('softArchivesTz', function() {
            $this->timestampTz('archived_at', 0)->nullable();
            $this->integer('archived_by', 0)->nullable();
        });

        Blueprint::macro('dropSoftArchives', function() {
            $this->dropColumn('archived_at');
            $this->dropColumn('archived_by');
        });

        Blueprint::macro('dropSoftArchivesTz', function() {
            $this->dropColumn('archived_at');
            $this->dropColumn('archived_by');
        });
    }
}
