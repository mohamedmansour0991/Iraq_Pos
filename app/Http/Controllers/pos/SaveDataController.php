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
            DB::table('AR_SalesInvoice_Main')->insert($data);

            return response()->json(['massage' => 'Data Save Succeful']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
        }
    }
    // public function save(Request $request)
    // {
    //     try {
    //         // Retrieve the MainID associated with the latest invoice
    //         $latestInvoice = DB::table('AR_SalesInvoice_Main')
    //             ->select('InvoiceNo')
    //             ->orderBy('InvoiceNo', 'desc')
    //             ->first();

    //         if ($latestInvoice) {
    //             $InvoiceNo = (int)$latestInvoice->InvoiceNo;
    //         } else {
    //         }


    //         $itemIDs = $request->input('ItemID');
    //         $prices = $request->input('Price');
    //         $quantities = $request->input('Quantity');

    //         $data2 = [];

    //         foreach ($itemIDs as $index => $itemID) {
    //             $total = $prices[$index] * $quantities[$index];
    //             $totalAfterDiscount = $total;
    //             $MainID = DB::table('AR_SalesInvoice_Main')
    //             ->select('id')
    //             ->orderBy('InvoiceNo', 'desc')
    //             ->pluck('id')
    //             ->first();
    //             $data2[] = [
    //                 'ItemID' => $itemID,
    //                 'Price' => $prices[$index],
    //                 'Quantity' => $quantities[$index],
    //                 'MainID' => $MainID,
    //                 'Total' => $total,
    //                 'TotalAfterDiscount' => $totalAfterDiscount,
    //             ];
    //         }

    //         $data = [
    //             'PaymentTypeID' => $request->input('PaymentTypeID'),
    //             'InvoiceNo' => $InvoiceNo + 1,
    //             'InvoiceDate' => Carbon::now(),
    //             'CustomerID' => $request->input('CustomerID'),
    //             'CustomerCurrecyID' => $request->input('CustomerCurrecyID'),
    //             'TotalInvoice' => $request->input('TotalInvoice'),
    //             'DelegateSalesID' => $request->input('DelegateSalesID'),
    //             'Note' => $request->input('Note'),
    //             'UserID' => $request->input('UserID'),
    //             'SafeID' => $request->input('SafeID'),
    //             'fdPaymentTypeID' => $request->input('PaymentTypeID'),
    //             'paid' => $request->input('paid'),
    //             'Residual' => $request->input('Residual'),
    //         ];
    //         DB::table('AR_SalesInvoice_Details')->insert($data2);
    //         DB::table('AR_SalesInvoice_Main')->insert($data);

    //         return response()->json(['message' => 'Data Save Success']);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'An error occurred', 'message' => $e->getMessage()], 500);
    //     }
    // }
}
