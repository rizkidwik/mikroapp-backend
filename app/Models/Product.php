<?php

namespace App\Models;

use App\Models\Rate;
use App\Models\Order;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'rate_limit_id','name','price','duration','image'
    ];

    public function getImageAttribute($image)
    {
        if($image){
        return asset('images/'.$image);
        } else {
            return 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg';
        }
    }
    public function rates()
    {
        return $this->belongsTo(Rate::class,'rate_limit_id','id');
    }

    public function voucher()
    {
        return $this->hasMany(Voucher::class,'product_id','id');
    }

    public function order()
    {
        return $this->hasMany(Order::class,'product_id','id');
    }


}
