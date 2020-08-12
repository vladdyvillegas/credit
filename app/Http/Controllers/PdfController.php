<?php

namespace Credit\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Credit\Models\Client\Client;
use Credit\Models\Operation\Operation;
use Credit\Models\Product\Product;
use Credit\Models\Operation\PaymentPlan;

class PdfController extends Controller
{
    //
    public function report($type, $date_report)
    {
        //
        $date_report = date('Y-m-d', strtotime($date_report));
        $gestion = date('Y', strtotime($date_report));

        $payments = Operation::query_report($gestion, $date_report, $type);

        $view =  \View::make('pdf.report', compact('payments', 'date_report', 'type'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream('report.pdf');
    }

    public function accrued_report($type, $date_report)
    {
        //
        $date_report = date('Y-m-d', strtotime($date_report));
        $gestion = date('Y', strtotime($date_report));

        $payments = Operation::query_accrued_report($gestion-1, $date_report, $type);

        $view =  \View::make('pdf.accrued_report', compact('payments', 'date_report', 'type'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream('accrued_report.pdf');
    }

    public function plan($id)
    {
        //
        $operation = Operation::FindOrFail($id);
        $payments = PaymentPlan::where('operation_id', $id)->get();

        $view =  \View::make('pdf.plan', compact('operation', 'payments'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('A4', 'portrait');
        return $pdf->stream('plan.pdf');

    }

    public function report_insurance($type)
    {
        //
        $insurances = DB::table('operations')
                      ->join('insurances', 'operations.id', '=', 'insurances.operation_id')
                      ->join('clients', 'operations.client_id', '=', 'clients.id')
                      ->select('operations.id as operation_id',
                              'operations.operation',
                              'clients.name',
                              'clients.type as type',
                              'operations.service_2',
                              DB::raw('sum(insurances.payment) as insure'),
                              DB::raw('sum(if(insurances.gestion = "2018" and insurances.status = "PAGADO", insurances.payment, 0)) as paid'),
                              DB::raw('sum(if(insurances.gestion = "2018" and insurances.status = "VENCIDO", insurances.payment, 0)) as expired'),
                              DB::raw('sum(if(insurances.gestion = "2018" and insurances.status = "VIGENTE", insurances.payment, 0)) as year1'),
                              DB::raw('sum(if(insurances.gestion = "2019" and insurances.status = "VIGENTE", insurances.payment, 0)) as year2'),
                              DB::raw('sum(if(insurances.gestion = "2020" and insurances.status = "VIGENTE", insurances.payment, 0)) as year3'),
                              'insurances.expired_date')
                      ->where(DB::raw('date_format(expired_date, "%Y")'), '>=', '2018')
                      ->groupBy('operations.id')
                      ->having('insure', '>', '0')
                      ->having('type', $type)
                      ->orderBy('operations.operation')
                      ->get();

        $view =  \View::make('pdf.report_insurance', compact('insurances', 'type'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('A4', 'landscape');
        return $pdf->stream('report_insurance.pdf');
    }

}
