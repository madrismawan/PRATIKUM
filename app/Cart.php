<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'status',
    ];

    protected $dates = ['deleted_at'];
}
