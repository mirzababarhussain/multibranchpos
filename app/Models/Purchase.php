<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';
   
    protected $guarded = [];

   

}
