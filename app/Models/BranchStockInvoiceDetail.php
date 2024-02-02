<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchStockInvoiceDetail extends Model
{
    use HasFactory;

    protected $table = 'branch_stock_invoice_details';
   
    protected $guarded = [];
}
