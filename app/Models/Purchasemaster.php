<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasemaster extends Model
{
    use HasFactory;

    protected $table = 'purchasemasters';
   
    protected $guarded = [];
}
