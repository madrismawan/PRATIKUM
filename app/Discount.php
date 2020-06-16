<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Discount extends Model
{
	use SoftDeletes;

    protected $table = 'discounts';

    protected $fillable = ['id_product', 'percentage', 'start', 'end'];
    
	protected $dates = ['deleted_at'];
}
