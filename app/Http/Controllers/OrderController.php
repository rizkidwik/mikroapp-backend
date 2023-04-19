<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Midtrans\CreateSnapTokenService;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id',Auth::user()->id)->get();

        return view('user.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'=>'required',
            'product_id'=>'required',
        ]);

        $p_order= new Order;
        $p_order->status = 'pending';
        $p_order->transaction_id = "MikroApp-".strtoupper(uniqid());
        $p_order->order_id = random_int(00000000,99999999);

        $p_order->quantity = 1;
        $p_order->user_id = $request->user_id;
        $p_order->product_id=$request->product_id;
        $p_order->payment_type = $request->payment_type;
        $p_order->code = $request->code;
        $p_order->pdf_url = isset($request->pdf_url) ? $request->pdf_url : null;

        $product = Product::find($request->product_id);
        $p_order->duration=$product->duration;

        $total = $product->price * $p_order->quantity;
        $p_order->gross_amount = $total;

        $p_order->save();



        // return response()->json($p_order);
        return redirect('order/'.$p_order->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $snapToken = $order->snap_token;
        if (is_null($snapToken)) {
            // Jika snap token masih NULL, buat token snap dan simpan ke database

            $midtrans = new CreateSnapTokenService($order);
            $snapToken = $midtrans->getSnapToken();

            $order->snap_token = $snapToken;
            $order->save();
        }
        // $voucher = Voucher::where('id',$order_);

        return view('user.orders.show', compact('order', 'snapToken'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order = Order::find($request->id);
        $json = json_decode($request->get('json'));

        $order->status = $json->transaction_status;
        $order->payment_type = $json->payment_type;
        $order->code = $json->status_code;
        $order->pdf_url = isset($json->pdf_url) ? $json->pdf_url : null;
        $order->save();

        return redirect('order/'.$order->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
