<?php

namespace App\Http\Controllers;

use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    private $title = "Oke Jasa";
    public function create(){
        $data = DB::table('kategori')->orderBy('id','desc')->get();
        $jasa = DB::table('jasa')->orderByDesc('id')->get();

        return view('pages.home',['title'=>$this->title,'jasa'=>$jasa,'kategori'=>$data]);
    }
}
