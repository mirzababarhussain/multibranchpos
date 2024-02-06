<?php

namespace App\Http\Controllers;

use App\Models\Prices;
use Illuminate\Http\Request;

class PricesController extends Controller
{
    public function verify_barcode($barcode){

        $result = 0;
        $barcode = Prices::where('external_barcode',$barcode)->first();
        if($barcode)
        {
            $result = 1;
        }
        return response()->json([
            "result" => $result
        ]);
    }
}
