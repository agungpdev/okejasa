<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    private $page = "Kategori";

    public function index(){
        $data = DB::table('kategori')->orderBy('id','desc')->get();
        return view('admin.kelolatoko.kategori',['title'=>$this->page,'data'=>$data]);
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
            $kategori = $request->input('kategori');

            $validate = ['kategori'=>$kategori];
            $rules = ['kategori'=>'required'];
            $customMsg = [
                'kategori'=>[
                    'required'=>'Kategori tidak boleh kosong'
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

            DB::table('kategori')->insert([
                'namakategori'=>$kategori,
                'created_at'=>now()
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

    public function edit(Request $request){
        try {
            DB::beginTransaction();
            $id = decrypt($request->id);

            $res = DB::table('kategori')->where('id',$id)->first();

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Get data berhasil',
                'result'=>$res
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

    public function update(Request $request){
        try {
            DB::beginTransaction();
            $kategori = $request->input('kategori');
            $id = decrypt($request->id);

            $validate = ['kategori'=>$kategori];
            $rules = ['kategori'=>'required'];
            $customMsg = [
                'kategori'=>[
                    'required'=>'Kategori tidak boleh kosong'
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

            DB::table('kategori')->where('id',$id)->update([
                'namakategori'=>$kategori,
                'updated_at'=>now()
            ]);

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'Data berhasil diupdate'
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
            $id = decrypt($request->id);
            $delete = DB::table('kategori')->where('id',$id)->delete();

            if(!$delete){
                throw new Exception('Data gagal dihapus',1);
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
