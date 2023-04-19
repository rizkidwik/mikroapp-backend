<?php

namespace App\Http\Controllers\API;

use RouterOS\Query;
use RouterOS\Client;
use App\Models\Config;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class MikrotikController extends Controller
{
    public function __construct()
    {
        $config = Config::first();

        $this->client = new Client([
            'host' => $config->host,
            'user' => $config->user,
            'pass' => $config->pass,
            'port' => $config->port,
        ]);
    }

    public function cek_koneksi(){
        $query = (new Query('/system/identity/print'));

        $this->client->query($query);

        $response = $this->client->query($query)->read();
        if($response != null){
        return ResponseFormatter::success($response,'Router connected');
        } else{
            return ResponseFormatter::error(null,'Router not connected',404);
        }
    }

    public function interface(){

        $query = (new Query('/ip/address/print'));

        $response = $this->client->query($query)->read();
        return ResponseFormatter::success($response,'Data berhasil diambil');
    }

    public function cek_hotspot(){
        $query = (new Query('/ip/hotspot/active/print'));

        $response = $this->client->query($query)->read();
        if($response){
        return ResponseFormatter::success($response,'Data berhasil diambil');
        }
        return ResponseFormatter::error(null,'Data kosong');

    }

    public function get_user_profile(){
        $query = (new Query('/ip/hotspot/user/profile/print'));

        $response = $this->client->query($query)->read();
        if($response){
            return ResponseFormatter::success($response,'Data berhasil diambil');
            }
            return ResponseFormatter::error(null,'Data kosong');
    }

    public function add_user_profile(Request $request){

    }

    public function generate_voucher(Request $request){
        $query =    (new Query('/ip/hotspot/user/add'))
        ->equal('name', 'test_gener' )
        ->equal('password','123')
        ->equal('limit-uptime','12h')
        ->equal('comment','comment');


        $response = $this->client->query($query)->read();
        if($response){
            return ResponseFormatter::success($response,'Data berhasil ditambahkan');
            }
            return ResponseFormatter::error(null,'Data kosong');
    }
}
