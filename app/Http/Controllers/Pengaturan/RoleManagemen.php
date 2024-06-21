<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleManagemen extends Controller
{
    private $page = "App Accounting | Role Managemen";
    private $repoRole;
    private $repoPermission;

    /**
     * __construct
     *
     * @param  mixed $repoRole
     * @param  mixed $repoPermission
     * @return void
     */
    public function __construct(RoleRepository $repoRole,PermissionRepository $repoPermission)
    {
        $this->repoRole = $repoRole;
        $this->repoPermission = $repoPermission;
    }

    /**
     * index
     *
     * @return void
     */
    public function index(){
        return view('admin.pengaturan.rolemanagemen',
            [
                'title'=>$this->page,
                'data'=>$this->repoRole->get_role(),
                'permission'=>$this->repoPermission->get_permission()
            ]
        );
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request){
        try {
            DB::beginTransaction();
            if(!$this->repoRole->create_role($request->input('rolename'))){
                throw new Exception("Gagal menambahkan role",1);
            }
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
}
