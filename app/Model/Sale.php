<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'dateSale', 'amount', 'discount', 'status'];

    public function client(){
        return $this->belongsTo(\App\Model\Client::class);
    }

    public function product(){
        return $this->belongsTo(\App\Model\Product::class, 'product_id', 'id');
    }
}
