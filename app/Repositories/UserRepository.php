<?php
/**
 * Created by PhpStorm.
 * User: Harrison Favour
 * Date: 17/11/2017
 * Time: 03:49 PM
 */

namespace App\Repositories;


use App\User;

class UserRepository extends BaseRepository{

    protected $model;

    public function __construct(User $user){
        $this->model = $user;
    }

    public function getById($id)
    {
        return $this->model->with(['roles'])->find($id);
    }

    public function getCategorizedEmployees($role)
    {
        if($role === 'supervisor'){
            return User::whereHas('roles', function ($query) {
                $query->where('name', 'like', '%ADMIN%')
                    ->orWhere('name', 'like', '%MODERATOR%');
            })->get(['full_name', 'id']);
        } else {
            return User::whereHas('roles', function ($query) {
                $query->where('name', 'like', '%USER%');
            })->get(['full_name', 'id']);
        }
    }
}