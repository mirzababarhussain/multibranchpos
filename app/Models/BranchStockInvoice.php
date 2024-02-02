<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchStockInvoice extends Model
{
    use HasFactory;

    protected $table = 'branch_stock_invoices';
   
    protected $guarded = [];
    
}
