<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BoxsController extends Controller
{
    public function getBox()
    {
        try {
            $result = DB::table('CM_Safes as s')
                ->select('s.ID', 's.AccountID', 's.BranchID', 'a.NameAr')
                ->join('GL_ChartOfAccount as a', 'a.ID', '=', 's.AccountID')
                ->get();

            return response()->json(['data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
}
