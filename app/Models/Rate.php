<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rate extends Model
{
    use HasFactory;

    protected $fillable  = [
        'rate_limit'
    ];

    public function products()
    {
        return $this->hasMany(Product::class,'rate_limit_id','id');
    }
}
