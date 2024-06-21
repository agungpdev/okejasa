<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionRepository
{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
    public function get_permission(){
        return $this->model->orderBy('id')->get(['id','name']);
    }
    public function find_permission($id){
        return DB::table('role_has_permissions')
        ->join('roles','role_has_permissions.role_id','=','roles.id')
        ->where('role_has_permissions.role_id',$id)->get(['roles.name','role_has_permissions.role_id','role_has_permissions.permission_id']);
    }
    public function store_permission($data,$role){
        $currentRole = Role::findByName($role);
        DB::table('role_has_permissions')->where('role_id',$currentRole->id)->delete();
        foreach ($data as $key => $value) {
            $permission = $this->model->findByName($value);
            $currentRole->givePermissionTo($permission);
        }
        return true;
    }
}
