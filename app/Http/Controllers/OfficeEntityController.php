<?php
/**
 * Created by PhpStorm.
 * User: ositadinma_nwangwu
 * Date: 11/6/2017
 * Time: 4:05 PM
 */

namespace App\Http\Controllers;


use App\Services\OfficeEntityService;
use Illuminate\Http\Request;

class OfficeEntityController extends Controller
{
    protected $service;

    public function __construct(OfficeEntityService $entityService)
    {
        $this->service = $entityService;
    }

    public function index()
    {
        return $this->service->getEntities(5);
    }

    public function show($id)
    {
        return $this->service->getEntity($id);
    }

    public function create(Request $request)
    {
        $r = [
            'name' => 'required',
            'lead' => 'required',
            'branch' => 'required',
            'office_entity_type' => 'required'
        ];
        $this->validate($request, $r);
        return $this->service->createEntity($request);
    }
    public function update($id, Request $request){
        $r = [
            'name' => 'required',
            'lead' => 'required',
            'branch' => 'required',
            'office_entity_type' => 'required'
        ];
        $this->validate($request, $r);
        return $this->service->updateEntity($id, $request);
    }

    public function update($id, Request $request)
    {
        $required = [
            'name' => 'required',
            'lead' => 'required',
            'branch' => 'required',
            'office_entity_type' => 'required'
        ];
        $this->validate($request, $required);
        return $this->service->update($id, $request);
    }

    public function delete($id)
    {
        return $this->service->delete($id);
    }

}