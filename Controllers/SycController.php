<?php

namespace Modules\Sync\Controllers;


use Illuminate\Http\Request;
use Modules\Base\Controller\BaseController;
use Modules\Flexwb\Services\ValidatorService;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class SyncController extends BaseController {

    protected $updatedRows = [];
    protected $insertedRows = [];
    protected $removedRows = [];
    protected $schema = [];

    public function __construct() {
        $this->repository = $repository;
    }

    public function resIndex(Request $request, $topRes) {

        return $this->repository->index($request, $topRes);
    }


    function syncPage(Request $request) {

        $syncData = $request->get('sync_data');
        $this->table = $syncData['table']??'';
        $this->schema = $syncData['schema']??'[]';
        $this->page = $syncData['page']??[];
        $this->pk = $syncData['pk']??'id';

        foreach($page as $item) {
            if($this->hasId($item)) {
                $this->updateRow($item);
            } else {
                $this->insertRow($item);
            }
        }

        $this->removeNonExistentIds();

        return [
                'inserted' => $this->insertedRows,
                'updated' => $this->updatedRows,
                'removed' => $this->removedRows
            ];
    }

    public function hasId($item) {
        $itemArray = (array) $item;
        if(array_key_exists($this->pk, $item)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateRow($item) {
        $updateStatus = \DB::table($tableName)
                ->where($this->pk, '=', $item[$this->pk])
                ->update($item);
        array_push($this->updatedRows, $item[$this->pk]);

    }

    public function insertRow($item) {
        $newInsertId = \DB::table($tableName)->insertGetId($data);
        array_push($this->insertedRows, $newInsertId);

    }

    public function removeNoneExistantIds() {
        return 'test';
    }


    
}
