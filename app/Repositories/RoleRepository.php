<?php

namespace App\Repositories;

use App\Models\Pengaturan\Role;
use Spatie\Permission\Models\Role as Roles;

class RoleRepository
{
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function create_role($role){
        return Roles::create(['name'=>$role]);
    }
    public function get_role(){
        return $this->model->get();
    }
    public function find_role($id){
        return $this->model->where('id',$id)->first('name');
    }
}
