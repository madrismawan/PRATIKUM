<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
    	'product_id', 'image_name',
    ];

    public function product(){
        return $this->belongsTo('App\Produk','product_id','id');
    }
}
