<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
use App\Models\Prices;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
   
    protected $guarded = [];


    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'cate_id');
    }

    public function prices(){
        return $this->hasMany(Prices::class, 'id', 'product_id');
    }
}

