<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function index(){
        $config = Config::all();
        if(!$config) {
            return 'asda';
        }
        return 'gagal';

        // return ResponseFormatter::success($config,'Data berhasil diambil');
    }

    public function store(Request $request){
        $request->validate([
            'host'=>['required','string','max:255',],
            'user'=>['required','string','max:255',],
            'pass'=>['required','string','max:255',],
            'port'=>['numeric','max:255',],
        ]);


        $cek_konfigurasi = Config::all()->first();

        if(!$cek_konfigurasi){
        $data = $request->all();
        $config = Config::create($data);
            if($config) {
                return ResponseFormatter::success($config,'Data konfigurasi berhasil ditambahkan');
            } else {
                return ResponseFormatter::error(null,'Data gagal ditambahkan',402);
            }
        } else {
            return ResponseFormatter::error(null,'Data konfigurasi sudah ada');
        }
    }
    public function update(Request $request,$id){
        $config = Config::find($id);
        if(!$config) {
            return response()->json(['message'=>'Data tidak ditemukan'],404);
        }

        $this->validate($request,[
            'host' => 'required',
            'user'=>'required',
            'pass'=>'required',
            'port'=>'numeric'
        ]);

        $data = $request->all();
        $config->fill($data);
        $config->save();
        return response()->json($config);
    }

    public function destroy($id){
        $config = Config::find($id);


        if(!$config) {
            return response()->json([
                ResponseFormatter::error(null,'Data konfigurasi tidak ada.',404)
            ]);
        }

        $config->delete();
        return response()->json(['message'=>'Data berhasil dihapus.'],200);
    }

}
