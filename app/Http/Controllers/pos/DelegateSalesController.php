<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DelegateSalesController extends Controller
{
    public function delegateSales()
    {
        $persons = DB::table('AR_DelegateSales')
            ->select('ID','NameAr','TargetInDefaultCurrency','TargetInOtherCurrency','IsActive','IsUpdate')
            ->get();
        return response()->json($persons);
    }
}

