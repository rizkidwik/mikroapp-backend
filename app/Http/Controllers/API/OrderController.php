<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\Midtrans\CreateSnapTokenService;
use RouterOS\Query;
use RouterOS\Client;
use App\Models\Config;

class OrderController extends Controller
{
    public function __construct()
    {
        // $config = Config::first();

        // $this->client = new Client([
        //     'host' => $config->host,
        //     'user' => $config->user,
        //     'pass' => $config->pass,
        //     'port' => $config->port,
        // ]);
    }

    public function all(Request $request){
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $status = $request->input('status');

        if($id)
        {
            $order = Order::with(['items.product'])->find($id);

            if($order)
                return ResponseFormatter::success(
                    $order,
                    'Data transaksi berhasil diambil'
                );
            else
                return ResponseFormatter::error(
                    null,
                    'Data transaksi tidak ada',
                    404
                );
        }

        $order = Order::with(['items.product'])->where('users_id', Auth::user()->id);

        if($status)
            $order->where('status', $status);

        return ResponseFormatter::success(
            $order->paginate($limit),
            'Data list transaksi berhasil diambil'
        );
    }
    public function store(Request $request)
    {

        $request->validate([
            'user_id'=>'required',
            'product_id'=>'required',
        ]);

        $user = User::where('id',$request->user_id)->get();
        $product = Product::where('id',$request->product_id)->first();
        $order = Order::create([
            'transaction_id' => "MikroApp-".strtoupper(uniqid()),
            'order_id' => random_int(00000000,99999999),
            'payment_type' => $request->payment_type,
            'pdf_url' => isset($request->pdf_url) ? $request->pdf_url : null,
            'quantity' => 1,
            'status' => 'pending',
            'duration' => $product->duration,
            'user_id'=>$request->user_id,
            'product_id'=>$request->product_id,
            'gross_amount' => $product->price,
        ]);

        // $payload = [
        //     'transaction_details' => [
        //         'order_id'      => $order->order_id,
        //         'gross_amount'  => $order->gross_amount,
        //     ],
        //     'customer_details' => [
        //         'first_name'    => $user->name,
        //         'email'         => $order->email,
        //     ],
        //     'item_details' => [
        //         [
        //             'id'       => $order->donation_type,
        //             'price'    => $order->amount,
        //             'quantity' => 1,
        //             'name'     => ucwords(str_replace('_', ' ', $order->donation_type))
        //         ]
        //     ]
        // ];

        $midtrans = new CreateSnapTokenService($order);
        $snapToken = $midtrans->getSnapToken();

        $order->snap_token = $snapToken;
        $order->save();

        return response()->json($order);
    }
    public function checkout(Request $request){
        $request->validate([
            'user_id'=>'required',
            'product_id'=>'required',
        ]);

        $user = User::where('id',$request->user_id)->get();
        $product = Product::where('id',$request->product_id)->first();
        $order = Order::create([
            'transaction_id' => "MikroApp-".strtoupper(uniqid()),
            'order_id' => random_int(00000000,99999999),
            'payment_type' => $request->payment_type,
            'pdf_url' => isset($request->pdf_url) ? $request->pdf_url : null,
            'quantity' => 1,
            'status' => 'pending',
            'duration' => $product->duration,
            'user_id'=>$request->user_id,
            'product_id'=>$request->product_id,
            'gross_amount' => $product->price,
        ]);

        $midtrans = new CreateSnapTokenService($order);
        $snapToken = $midtrans->getSnapToken();

        $order->snap_token = $snapToken;
        $order->save();

        return ResponseFormatter::success([
            'order'=>$order
        ],'Order Created');
    }

    public function status($order_id)
    {
        try {
            $order = Order::where('order_id',$order_id)->with(['product','product.rates'])->firstOrFail();
            return ResponseFormatter::success([
                'order' => $order
            ],'Order Status Fetched');
        } catch (\Throwable $th) {
            return ResponseFormatter::error([
            ],$th,404);
        }
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
