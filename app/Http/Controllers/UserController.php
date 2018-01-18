<?php
/**
 * Created by PhpStorm.
 * User: Harrison Favour
 * Date: 17/11/2017
 * Time: 03:59 PM
 */

namespace App\Http\Controllers;


use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{

    private $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    public function getAllUsers(Request $request)
    {
        $n = $request->input('n') ?? null;
        $fields = $request->input('fields') ? explode(',', $request->input('fields')) : null;
        return $this->service->getAll($n, $fields);
    }

    // public function getAllUsersNameAndId()
    // {
    //     $n = $request->n ?? null;
    //     return $this->service->getAll($n, ['last_name', 'first_name', 'id']);
    // }

    public function getById($id)
    {
        return $this->service->getById($id);
    }

    public function create(UserRequest $request)
    {
        return $this->service->create($request, 'User');
    }

    public function update($id, UserRequest $request)
    {
        return $this->service->update($id, $request);
    }

    public function delete($id)
    {
        return $this->service->delete($id);
    }
}