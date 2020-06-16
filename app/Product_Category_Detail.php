<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product_Category_Detail extends Model
{
	protected $table='product_category_details';

    use SoftDeletes;

    protected $fillable = [
        'category_id', 'product_id', 'category',
    ];

    protected $dates = ['deleted_at'];
}
