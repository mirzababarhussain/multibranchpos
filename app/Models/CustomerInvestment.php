<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvestment extends Model
{
    use HasFactory;

    protected $table = 'customer_investments';
   
    protected $guarded = [];
}
