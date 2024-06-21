<?php

namespace App\Http\Controllers\Toko;

use App\Http\Controllers\Controller;
use App\Services\UploadFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class JasaController extends Controller
{
    private $page = "Jasa";
    private $uploadFileService;

    public function index(){
        $data = DB::table('kategori')->orderBy('id','desc')->get();
        $jasa = DB::table('jasa')->orderByDesc('id')->get();
        $result=[];
        foreach ($jasa as $key => $value) {
            $newjasa=[];
            $newjasa['id']=$value->id;
            foreach ($data as $key => $val) {
                if($val->id == $value->idkategori){
                    $newjasa['kategori']=$val->namakategori;
                }
            }
            $newjasa['namajasa']=$value->namajasa;
            $newjasa['gambar']=$value->gambar;
            $newjasa['deskripsi']=$value->deskripsi;
            $newjasa['rating']=$value->rating;
            $newjasa['hargasebelum']=$value->hargasebelum;
            $newjasa['hargasetelah']=$value->hargasetelah;
            $newjasa['created_at']=$value->created_at;
            $newjasa['updated_at']=$value->updated_at;
            $result[]=(object)$newjasa;
        }

        return view('admin.kelolatoko.jasa',['title'=>$this->page,'data'=>$data,'jasa'=>$result]);
    }

    public function store(Request $request,UploadFileService $uploadFileService)
    {
        try {
            DB::beginTransaction();
            $jasa = $request->input('jasa');
            $kategori = $request->input('kategori');
            $rating = $request->input('rating');
            $hargasebelum = $request->input('harga');
            $hargasetelah = $request->input('hargadiskon');
            $deskripsi = $request->input('deskripsi');
            // Get the uploaded file from the request
            $file = $request->file('gambar');

            $validate = ['kategori'=>$kategori,'jasa'=>$jasa,'rating'=>$rating,'hargasebelum'=>$hargasebelum,'hargasetelah'=>$hargasetelah,'deskripsi'=>$deskripsi];
            $rules = ['kategori'=>'required','jasa'=>'required','rating'=>'required','hargasebelum'=>'required','hargasetelah'=>'required','deskripsi'=>'required'];
            $customMsg = [
                'jasa'=>[
                    'required'=>'Jasa tidak boleh kosong'
                ],
                'kategori'=>[
                    'required'=>'Kategori tidak boleh kosong'
                ],
                'rating'=>[
                    'required'=>'Rating tidak boleh kosong'
                ],
                'hargasebelum'=>[
                    'required'=>'Harga sebelum diskon tidak boleh kosong'
                ],
                'hargasetelah'=>[
                    'required'=>'Harga setelah diskon tidak boleh kosong'
                ],
                'deskripsi'=>[
                    'required'=>'Deskripsi tidak boleh kosong'
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

            // Define the storage path
            $path = 'thumbnail';

            $fileName = $fileName ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            // get the uploaded file name
            $uploadedFileName = "{$fileName}_".time().".{$extension}";

            DB::table('jasa')->insert(
                [
                    'idkategori'=>$kategori,
                    'namajasa'=>$jasa,
                    'gambar'=>$uploadedFileName,
                    'deskripsi'=>$deskripsi,
                    'rating'=>$rating,
                    'hargasebelum'=>$hargasebelum,
                    'hargasetelah'=>$hargasetelah,
                    'created_at'=>now()
                ]
            );

            // Upload the image and get the file path
            $this->uploadFileService = $uploadFileService;
            if(!$this->uploadFileService->uploadImage($file, $path, $uploadedFileName))
            {
                throw new \Exception("Foto gagal di upload", 1);
            };

            DB::commit();
            $status = [
                'success' => true,
                'message' => 'data berhasil disimpan'
            ];
            return response()->json($status);
        } catch (\Throwable $th) {
            //throw $th;
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
