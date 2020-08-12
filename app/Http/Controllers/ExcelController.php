<?php

namespace Credit\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Credit\Models\Client\Client;
use Credit\Models\Operation\Operation;
use Credit\Models\Product\Product;
use Credit\Models\Operation\PaymentPlan;

class ExcelController extends Controller
{
    //
    public function exportReport()
    {
        //
        \Excel::create('ClientesPropios', function($excel) {
            $clients = PaymentPlan::where('operation_id', '9')
                                    ->where('payment_date', '<>', '')
                                    ->get();
            $excel->sheet('ClientesPropios', function($sheet) use($clients) {
                $sheet->fromArray($clients);
            });

        })->export('xlsx');
    }

    public function testView()
    {
        //
        $gestions = DB::table('vw_payments_gestion')->get();
        foreach ($gestions as $gestion) {
            echo $gestion->gestion;
        }
    }
}
