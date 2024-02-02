<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendorbalance extends Model
{
    use HasFactory;

    protected $table = 'vendorbalances';
   
    protected $guarded = [];
}
