<?php

namespace App\Http\Controllers\pos;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class SaveDataController extends Controller
{
    public function save(Request $request)
    {
        try {
            $latestInvoice = DB::table('AR_SalesInvoice_Main')
                ->select('InvoiceNo')
                ->orderBy('InvoiceNo', 'desc')
                ->first();
            if ($latestInvoice) {
                $InvoiceNo = (int)$latestInvoice->InvoiceNo;
            } else {
            }
            $data = [
                'PaymentTypeID' => $request->input('PaymentTypeID'),
                'InvoiceNo' => $InvoiceNo + 1,
                'InvoiceDate' => Carbon::now(),
                'CustomerID' => $request->input('CustomerID'),
                'CustomerCurrecyID' => $request->input('CustomerCurrecyID'),
                'TotalInvoice' => $request->input('TotalInvoice'),
                'DelegateSalesID' => $request->input('DelegateSalesID'),
                'Note' => $request->input('Note'),
                'UserID' => $request->input('UserID'),
                'SafeID' => $request->input('SafeID'),
                'fdPaymentTypeID' => $request->input('PaymentTypeID'),
                'paid' => $request->input('paid'),
                'Residual' => $request->input('Residual'),
            ];

            $itemIDs = $request->input('ItemID');
            $prices = $request->input('Price');
            $quantities = $request->input('Quantity');

            $data2 = [];

            $latestMainID = DB::table('AR_SalesInvoice_Main')
                ->select('ID')
                ->orderBy('ID', 'desc')
                ->first();
            if ($latestMainID) {
                $MainID = (int)$latestMainID->ID;
            } else {
            }
            foreach ($itemIDs as $index => $itemID) {
                $total = $prices[$index] * $quantities[$index];
                $totalAfterDiscount = $total;

                $data2[] = [
                    'ItemID' => $itemID,
                    'Price' => $prices[$index],
                    'Quantity' => $quantities[$index],
                    'MainID' => $MainID,
                    'Total' => $total,
                    'TotalAfterDiscount' => $totalAfterDiscount,
                ];
            }
            DB::table('AR_SalesInvoice_Details')->insert($data2);
            DB::table('AR_SalesInvoice_Main')->insert($data);

            return response()->json(['massage' => 'Data Save Succeful']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
    // public function save2(Request $request)
    // {
    //     try {


    //         $itemIDs = $request->input('ItemID');
    //         $prices = $request->input('Price');
    //         $quantities = $request->input('Quantity');

    //         $data2 = [];

    //         $latestMainID = DB::table('AR_SalesInvoice_Main')
    //             ->select('ID')
    //             ->orderBy('ID', 'desc')
    //             ->first();
    //         if ($latestMainID) {
    //             $MainID = (int)$latestMainID->ID;
    //         } else {
    //         }
    //         foreach ($itemIDs as $index => $itemID) {
    //             $total = $prices[$index] * $quantities[$index];
    //             $totalAfterDiscount = $total;

    //             $data2[] = [
    //                 'ItemID' => $itemID,
    //                 'Price' => $prices[$index],
    //                 'Quantity' => $quantities[$index],
    //                 'MainID' => $MainID,
    //                 'Total' => $total,
    //                 'TotalAfterDiscount' => $totalAfterDiscount,
    //             ];
    //         }
    //         DB::table('AR_SalesInvoice_Details')->insert($data2);
    //         return response()->json(['message' => 'Data saved successfully']);
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
    //     }
    // }
}
