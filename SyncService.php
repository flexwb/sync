<?php
namespace Modules\Sync;


class SyncService {
    
    public static function routes($routes = []) {

        \Route::get('/sync', function () {
            return 'sync';
        });

        Route::post('/sync/page','\Modules\Sync\Controllers\SyncController@syncPage');

        return 1;

    }



}