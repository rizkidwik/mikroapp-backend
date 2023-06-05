<?php

namespace App\Http\Controllers;

use RouterOS\Query;
use RouterOS\Client;
use App\Models\Order;
use App\Models\Config;
use App\Models\Voucher;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
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
    public function receive(Request $request)
    {
        $callback = new CallbackService;
        if ($callback->isSignatureKeyVerified($request)) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                // update status di table

                Order::where('id', $order->id)->update([
                    'status' => "settlement",
                    'payment_type' => $notification->payment_type,
                    'code' => $notification->status_code,
                ]);



                // Generate kode voucher
                $random = Str::random(4);

                $cek_kode = Voucher::where('code',$random)->first();
                $cek_transaksi = Voucher::where('order_id',$order->order_id)->first();
                if(!$cek_kode && !$cek_transaksi){
                    $comment = $order->order_id . '-' . $order->duration . '-' . date('Ymd_H:i:s');
                    $query =    (new Query('/ip/hotspot/user/add'))
                        ->equal('name', $random )
                        ->equal('password',$random)
                        ->equal('limit-uptime',$order->duration)
                        ->equal('comment',$comment);
                $response = $this->client->query($query)->read();

                    Voucher::create([
                        'order_id'=> $order->order_id,
                        'product_id' => $order->product_id,
                        'transaction_id' => $notification->transaction_id,
                        'code' => $random,
                    ]);
                }

            }

            if ($callback->isExpire()) {
                Order::where('id', $order->id)->update([
                    'transaction_id' => $notification->transaction_id,
                    'status' => "expired",
                    'code' => $notification->status_code,
                ]);
            }

            if ($callback->isCancelled()) {
                Order::where('id', $order->id)->update([
                    'transaction_id' => $notification->transaction_id,
                    'payment_type' => $notification->payment_type,
                    'status' => "cancelled",
                    'code' => $notification->status_code,
                ]);
            }
            if ($callback->isDeny()) {
                Order::where('id', $order->id)->update([
                    'payment_type' => $notification->payment_type,
                    'transaction_id' => $notification->transaction_id,
                    'status' => "deny",
                    'code' => $notification->status_code,
                ]);
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }

    public function success(Request $request)
    {
        $random = Str::random(4);
        return view('user.midtrans.success',compact('random'));
    }
}
