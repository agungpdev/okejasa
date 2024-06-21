<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class MenuManagemen extends Controller
{
    private $page = "App Accounting | Menu Managemen";
    private $repoMenu;

    public function __construct(MenuRepository $repoMenu)
    {
        $this->repoMenu = $repoMenu;
    }

    public function index(){
        $menu = $this->repoMenu->get_menu();
        $result = [];
        $nameController=[];
        $icon = DB::table('master_icons')->orderBy('name')->get();

        foreach ($menu as $key => $value) {
            $data=[];
            $newprop=[];

            $data['id']=$value->id;
            $data['menu']=$value->menu;
            $data['menu_active']=$value->is_active;

            if($value->route){
                $routemenu=explode('%',$value->route);
                $data['route']=$routemenu[1];
            }else{
                $data['route']=$value->route;
            }

            $submenu = $this->repoMenu->get_submenu($value->id);

            foreach ($submenu as $sub) {
                if ($sub->menu_id == $value->id) {
                    $newsub=[];
                    $newsub['id']=$sub->id;
                    $newsub['menu_id']=$sub->menu_id;
                    $newsub['submenu']=$sub->submenu;
                    $newsub['is_active']=$sub->is_active;
                    $routesub=explode('%',$sub->route);
                    $newsub['route']=$routesub[1];
                    $newsub = (object) $newsub;
                    $newprop[] = $newsub;
                }
            }
            $newmenu=['submenu'=>$newprop];
            $newmenu =(object) array_merge($data,$newmenu);
            $result[] = $newmenu;
        }

        $namelist = Route::getRoutes()->getRoutesByName();
        foreach ($namelist as $key => $value) {
            if(!str_contains($key,'sanctum')&&!str_contains($key,'ignition')&&!str_contains($key,'home')&&!str_contains($key,'profile')&&!str_contains($key,'register')&&!str_contains($key,'login')&&!str_contains($key,'logout')&&!str_contains($key,'password')&&!str_contains($key,'verification')){
                $item=explode('.',$key);
                if(count($item)<=1){
                    $nameController[$key]=$value->uri;
                }
            }
        }

        // dd($nameController);

        // foreach (Route::getRoutes()->getRoutes() as $route) {
        //     $action = $route->getAction();
        //     if(array_key_exists('controller',$action) && array_key_exists('prefix',$action)){
        //         if($action['prefix'] && $action['prefix'] != 'api' && $action['prefix'] != 'sanctum' && $action['prefix'] != '_ignition'){
        //             $prefix=$action['prefix'];
        //             $item=explode('@', $action['controller']);
        //             if(count($item)>1){
        //                 $name = explode('\\',$item[0]);
        //                 $name = end($name);
        //                 $fn = $item[1];
        //                 if($fn=='index'){
        //                     $nameController[$name.'@'.$fn]=$prefix;
        //                 }
        //             }
        //         }
 
        //     }
        // }

        return view('admin.pengaturan.menumanagemen',[
            'title'=>$this->page,
            'menu'=>$result,
            'route'=>$nameController,
            'icons'=>$icon
        ]);
    }
    public function store(Request $request){

        try {
            DB::beginTransaction();
            $menu = $request->input('menu');
            $route = $request->input('route');
            $haveSub = $request->input('sub');
            $icon = $request->input('icons');

            if(!$menu){
                throw new Exception('Nama menu tidak boleh kosong',1);
            }

            $fileArr = ['menu'=>$menu];
            $rules = ['menu'=>'unique:menu,menu'];
            $customMsg = ['unique'=>'Menu sudah terdaftar'];
            $validator = Validator::make($fileArr,$rules,$customMsg);

            if($validator->fails()){
                foreach ($validator->errors()->getMessages() as $key => $er_msg) {
                    throw new \Exception($er_msg[0], 1);
                }
            }

            if(!$haveSub){
                if(!$route){
                    throw new Exception('Silahkan pilih route terlebih dahulu',1);
                }
                DB::table('menu')->insert([
                    'menu'=>$menu,
                    'route'=>$route,
                    'icon'=>$icon,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
            }else{
                $submenu=$request->input('submenus');
                foreach ($submenu as $key => $value) {
                    $rules = ['submenu'=>'required','route'=>'required'];
                    $customMsg = ['required'=>'Submenu atau route tidak boleh kosong'];
                    $validator = Validator::make($value,$rules,$customMsg);

                    if($validator->fails()){
                        foreach ($validator->errors()->getMessages() as $key => $er_msg) {
                            throw new \Exception($er_msg[0], 1);
                        }
                    }
                }
                $parent = DB::table('menu')->insertGetId([
                    'menu'=>$menu,
                    'icon'=>$icon,
                    'route_group'=>$request->submenus[0]['route'],
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
                foreach ($request->submenus as $key => $value) {
                    $arr = ['menu_id'=>$parent,'is_active'=>1,'created_at'=>now(),
                    'updated_at'=>now()];
                    $data = array_merge($arr,$value);
                    DB::table('submenu')->insert($data);
                }
            }

            $this->repoMenu->menu_to_permission($menu);

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ];
            return response()->json($status);

        } catch (\Throwable $th) {

            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }

    public function edit_menu(Request $request){
        try {
            DB::beginTransaction();
            $menu = $request->input('menu');
            $submenu = $request->input('submenu');

            if($submenu){
                $submenu = decrypt($submenu);
                $result=[];
                $ori = DB::table('submenu')->join('menu','submenu.menu_id','=','menu.id')->where('submenu.id',$submenu)->first(['submenu.id','submenu.menu_id','submenu.route','submenu.submenu','menu.menu']);
                foreach ($ori as $key => $value) {
                    if($key=='menu_id'){
                        $result[$key]=encrypt($value);
                    }else{
                        $result[$key]=$value;
                    }
                }
                $result = (object) $result;
                $parent = false;
            }else{
                $menu = decrypt($menu);
                $result = DB::table('menu')->where('id',$menu)->first(['id','menu','route']);
                $parent = true;
            }

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Get data berhasil',
                'result'=>$result,
                'parent'=>$parent
            ];

            return response()->json($status);

        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }

    public function update_menu(Request $request){

        try {
            DB::beginTransaction();
            $id = base64_decode($request->input('id'));
            $menu = $request->input('menu');
            $route = $request->input('route');
            $oldMenu = DB::table('menu')->where('id',$id)->first();

            if($route){
               DB::table('menu')->where('id',$id)->update([
                    'menu'=>$menu,
                    'route'=>$route,
                    'updated_at'=>now()
                ]);
            }else{
                DB::table('menu')->where('id',$id)->update(['menu'=>$menu,'updated_at'=>now()]);
            }

            if(!DB::table('permissions')->where('name',$oldMenu->menu)->update(['name'=>$menu,'updated_at'=>now()])){
                throw new Exception('Gagal update permissions',1);
            }

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Update data berhasil',
            ];

            return response()->json($status);

        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }

    public function update_submenu(Request $request){

        try {
            DB::beginTransaction();
            $id = base64_decode($request->input('id'));
            $menuId = decrypt($request->input('menu'));
            $submenu = $request->input('submenu');

            if(!DB::table('submenu')->where('id',$id)->update([
                'submenu'=>$submenu,
                'menu_id'=>$menuId,
                'updated_at'=>now()
            ])){
                throw new Exception('Gagal update submenu',1);
            }

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Update data berhasil',
            ];

            return response()->json($status);

        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }

    public function activated_menu(Request $request){
        try {
            DB::beginTransaction();
            $id = decrypt($request->input('id'));
            $check = $request->input('check');
            $parentId = $request->input('parent');

            $status = $this->repoMenu->activated_menu($id,$check,$parentId);

            DB::commit();

            return response()->json($status);

        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }

    public function store_submenu(Request $request){

        try {
            DB::beginTransaction();
            $submenu = $request->input('submenu');
            $menu = $request->input('menu');
            $route = $request->input('route');

            $validate = ['submenu'=>$submenu,'menu'=>$menu,'route'=>$route];
            $rules = ['submenu'=>'required','menu'=>'required','route'=>'required'];
            $customMsg = [
                'submenu'=>[
                    'required'=>'Submenu tidak boleh kosong'
                ],
                'menu'=>[
                    'required'=>'Menu tidak boleh kosong'
                ],
                'route'=>[
                    'required'=>'Silahkan pilih route terlebih dahulu'
                ],
            ];

            $validator = Validator::make($validate,$rules,$customMsg);

            foreach ($validator as $key => $value) {
                if($validator->fails()){
                    foreach ($validator->errors()->getMessages() as $key => $er_msg) {
                        throw new \Exception($er_msg[0], 1);
                    }
                }
            }

            $id = decrypt($menu);
            DB::table('menu')->where('id',$id)->update(['route'=>'','updated_at'=>now()]);
            DB::table('submenu')->insert([
                'submenu'=>$submenu,
                'menu_id'=>$id,
                'route'=>$route,
                'is_active'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ];
            return response()->json($status);
        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }

    public function destroy(Request $request){

        try {
            DB::beginTransaction();
            $parent = $request->input('parent');
            $id = $request->input('id');
            if($parent){
                $parent = decrypt($parent);
                $parent = explode('@',$parent);
                if(DB::table('menu')->where('id',$parent[0])->delete()){
                    DB::table('permissions')->where('name',$parent[1])->delete();
                }

            }else{
                $id = decrypt($id);
                DB::table('submenu')->where('id',$id)->delete();
            }

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Data berhasil dihapus'
            ];
            return response()->json($status);

        } catch (\Throwable $th) {
            DB::rollBack();

            if ($th->getCode() == 1) {
                $pesan_error = $th->getMessage();
            }else{
                $pesan_error=$th;
            }
            $status = [
                'error' => true,
                'message' => $pesan_error
            ];
            return response()->json($status);
        }
    }
}
