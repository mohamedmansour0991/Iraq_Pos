<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GroupsController extends Controller
{


    // public function groups()
    // {
    //     // $persons = DB::table('CM_Safes as s')
    //     //     ->select('s.ID','s.AccountID','s.BranchID','a.NameAr')
    //     //     ->JOIN('GL_ChartOfAccount AS a', 'a.ID', '=', 's.AccountID')
    //     //     ->get();
    // }




    public function groups()
    {
        try {
            $result = DB::table(function ($query) {
                // Subquery for the first part of the union
                $query->select(
                    'g.ID',
                    'g.NameAr',
                )
                    ->from('SC_ItemsGroups as g')
                    ->join('SC_Items as i', 'i.ItemGroupID', '=', 'g.ID')
                    ->where('g.IsActive', 1)
                    ->whereNull('i.Barcode')
                    ->groupBy('g.ID', 'g.NameAr', 'g.ParentID', 'g.OrderNo');
            }, 't');

            // Joining with SC_ItemsGroups outside of the subquery
            $result->join('SC_ItemsGroups as g', 'g.ID', '=', 't.ID')
                ->orderBy('g.OrderNo')
                ->select('t.*');

            // Executing the final query
            $results = $result->get();

            return response()->json(['data' => $results]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function items(Request $request)
    {
        try {
            $groupId = $request->input('groupId');
            $result = Db::table('SC_Items as i')->select(
                'i.ID',
                'i.NameAr',
                'i.OrderNo',
                'ItemGroupID',
                DB::raw('CAST(i.Price AS FLOAT) as SalesPrice')
            )
                ->where('i.IsActive', 1)
                ->whereNull('i.Barcode')
                ->where('ItemGroupID', $groupId)
                // ->where('i.IsShow', '<>', 0)
                // ->whereNull('i.allaw_lab')
                ->get();
            return response()->json(['data' => $result]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function getItemPrices(Request $request)
    {
        try {
            $itemID = $request->input('itemID');

            $itemsQuery = DB::table('SC_Items as u')
                ->join('SC_MeasurementUnits as s', 'u.UnitID', '=', 's.ID')
                ->where('u.ID', $itemID)
                ->select('s.NameAr', DB::raw('1 as UnitConvert'), 'u.ID', DB::raw('CAST(u.Price AS FLOAT) as SalesPrice'));

            $results = $itemsQuery->get();

            return response()->json(['data' => $results]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function searchBarcode(Request $request)
    {
        try {
            $barcode = $request->input('barcode');

            $itemsQuery = DB::table('SC_Items as u')
                ->join('SC_MeasurementUnits as s', 'u.UnitID', '=', 's.ID')
                ->where('u.Barcode', $barcode) // Change the condition to search by barcode
                ->select('u.ID', 'u.NameAr', 's.NameAr as UnitName', DB::raw('1 as UnitConvert'), 's.ID as UnitID', DB::raw('CAST(u.Price AS FLOAT) as SalesPrice'));

            $results = $itemsQuery->get();

            return response()->json(['data' => $results]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function searchByNameAr(Request $request)
    {
        try {
            $nameAr = $request->input('name');
            if (!empty($nameAr)) {
                $itemsQuery = DB::table('SC_Items as u')
                    ->join('SC_MeasurementUnits as s', 'u.UnitID', '=', 's.ID')
                    ->where('u.NameAr', 'LIKE', '%' . $nameAr . '%') // Change the condition to search by NameAr
                    ->select('u.ID', 'u.NameAr', 's.NameAr as UnitName', DB::raw('1 as UnitConvert'), 's.ID as UnitID', DB::raw('CAST(u.Price AS FLOAT) as SalesPrice'));
    
                $results = $itemsQuery->get();
            } else {
                $results = 'من فضلك قم بإدخال اسم المادة';
            }
    
            return response()->json(['data' => $results]);
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
