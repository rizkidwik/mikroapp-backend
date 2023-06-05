<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoucherController extends Controller
{
    public function fetch(Request $request)
    {
        try {
            $voucher = Voucher::where('order_id',$request->order_id)->firstOrFail();
            return ResponseFormatter::success($voucher,'Fetch Success');
        } catch (\Throwable $e) {
            return ResponseFormatter::error(
                $e,
                'Data Voucher tidak ada',
                404
            );
        }

    }
}
