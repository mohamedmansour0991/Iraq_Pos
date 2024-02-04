<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PaymentMethodController extends Controller
{
    public function payment()
    {
        $payment = DB::table('Main_FastDefinitions_Details')
            ->select('ID','NameAr')
            ->where('DefinitionID',4)
            ->Where('ID','<>',3)
            ->get();
        return response()->json($payment);
    }
}
