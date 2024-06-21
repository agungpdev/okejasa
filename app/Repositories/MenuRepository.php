<?php

namespace App\Repositories;

use App\Models\Pengaturan\MenuManagemen;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuRepository
{
    protected $model;

    public function __construct(MenuManagemen $model)
    {
        $this->model = $model;
    }

    public function get_menu(){
        return DB::table('menu')->get();
    }

    public function get_submenu($id){
        return DB::table('submenu')->where('menu_id',$id)->get();
    }

    public function menu_to_permission($menu){
        $roleAdmin = Role::findByName('Administrator');
        $permission = Permission::create(['name'=>$menu]);
        $roleAdmin->givePermissionTo($permission);
    }
    public function activated_menu($id,$check,$parentId){
        if($check){
            if($parentId){
                DB::table('submenu')->where('id',$id)->update(['is_active'=>1,'updated_at'=>now()]);
                $msg="Submenu diaktifkan";
                $reload=false;
            }else{
                $current = DB::table('menu')->where('id',$id)->first();
                DB::table('menu')->where('id',$id)->update(['is_active'=>1,'updated_at'=>now()]);
                DB::table('submenu')->where('menu_id',$current->id)->update(['is_active'=>1,'updated_at'=>now()]);
                $msg="Menu diaktifkan";
                $reload=true;
            }
            $icon='success';
        }else{
            if($parentId){
                DB::table('submenu')->where('id',$id)->update(['is_active'=>0,'updated_at'=>now()]);
                $msg="Submenu dimatikan";
                $reload=false;
            }else{
                $current = DB::table('menu')->where('id',$id)->first();
                DB::table('menu')->where('id',$id)->update(['is_active'=>0,'updated_at'=>now()]);
                DB::table('submenu')->where('menu_id',$current->id)->update(['is_active'=>0,'updated_at'=>now()]);
                $msg="Menu dimatikan";
                $reload=true;
            }
            $icon='error';
        }
        return ['success' => true,
        'icon'=>$icon,
        'message' => $msg,
        'reload'=>$reload];
    }
}
