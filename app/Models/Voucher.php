<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id","code"
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
