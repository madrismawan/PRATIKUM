<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{

	use SoftDeletes;

    protected $table = 'product_categories';

    protected $fillable = [
        'category_name',
    ];

    protected $dates = ['deleted_at'];
}
