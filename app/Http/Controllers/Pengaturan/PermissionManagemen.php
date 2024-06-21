<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionManagemen extends Controller
{
    private $repoPermission;

    public function __construct(PermissionRepository $repoPermission)
    {
        $this->repoPermission = $repoPermission;
    }

    public function edit(Request $request, RoleRepository $repoRole){
        try {
            DB::beginTransaction();
            $id = decrypt($request->input('id'));
            $permission = $this->repoPermission->get_permission();
            $mePermission = $this->repoPermission->find_permission($id);
            $roles = $repoRole->find_role($id);
            $data=[];

            foreach ($permission as $key => $value) {
                $currentPermission = $value;
                if(count($mePermission) != 0){
                    foreach ($mePermission as $key2 => $val) {
                        $currentRole = $mePermission[$key2];
                        if($currentRole->permission_id === $currentPermission->id && $currentRole->permission_id != null){
                            $chekVal = true;
                            break;
                        }else{
                            $chekVal=false;
                        }
                    }
                }else{
                    $chekVal=false;
                }
                $currentPermission['check']=$chekVal;
                $data[]=$currentPermission;
            }

            if($roles->name == 'Administrator'){
                $admin = true;
            }else{
                $admin=false;
            }

            DB::commit();
            $status = [
                'success' => true,
                'result' =>$data,
                'role'=>$roles,
                'admin'=>$admin,
                'message' => 'Get data berhasil'
            ];
            return response()->json($status,200);
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

    public function store(Request $request){
        try {
            DB::beginTransaction();
            $role = $request->input('role');
            $data=[];

            foreach ($request->input() as $key => $value) {
                if($key == "_token" || $key == "role"){
                    // $data[]=$value;
                }else{
                    $data[]=$value;
                }
            }

            $this->repoPermission->store_permission($data,$role);

            DB::commit();

            $status = [
                'success' => true,
                'message' => 'Berhasil menyimpan'
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
