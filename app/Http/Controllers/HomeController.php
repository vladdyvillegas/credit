<?php

namespace Credit\Http\Controllers;

use DB;
use Credit\Http\Requests;
use Illuminate\Http\Request;
use Credit\Models\Client\Client;
use Credit\Models\Dim\DimCreditReport;
use Credit\Models\Operation\Operation;
use Credit\Models\Process\Gestion;
use Credit\Models\Process\Period;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $gestion_open = Gestion::all()->where('status', 'ABIERTO')->min('gestion');
        $period_open = Period::all()->where('gestion', $gestion_open)->where('status', 'ABIERTO')->min('period');

        $pie_prop = DB::select('SELECT SUM(balance_mora) AS "enMora",
                                       SUM(balance) AS "alDia",
                                       SUM(balance_mora1) AS "mora1",
                                       SUM(balance_mora2) AS "mora2",
                                       SUM(balance_mora3) AS "mora3"
                                FROM (SELECT @prm_gestion := "2018", @prm_client_type := "PROPIO") alias, vw_delay
                                WHERE period = ?', [$period_open-1]);

        $pie_finan = DB::select('SELECT SUM(balance_mora) AS "enMora",
                                       SUM(balance) AS "alDia",
                                       SUM(balance_mora1) AS "mora1",
                                       SUM(balance_mora2) AS "mora2",
                                       SUM(balance_mora3) AS "mora3"
                                FROM (SELECT @prm_gestion := "2018", @prm_client_type := "FINANCIAL") alias, vw_delay
                                WHERE period = ?', [$period_open-1]);

        $bar_prop = DB::select('SELECT period,
                                       FORMAT((balance/last_balance)*100, 2) AS "indice",
                                       FORMAT((balance_mora/last_balance)*100, 2) AS "indice_mora",
                                    	 FORMAT((balance_mora1/last_balance)*100, 2) AS "indice_mora1",
                                    	 FORMAT((balance_mora2/last_balance)*100, 2) AS "indice_mora2",
                                    	 FORMAT((balance_mora3/last_balance)*100, 2) AS "indice_mora3"
                                FROM (SELECT @prm_gestion := "2018", @prm_client_type := "PROPIO") alias, vw_delay
                                ORDER BY period');

        $bar_finan = DB::select('SELECT period,
                                       FORMAT((balance/last_balance)*100, 2) AS "indice",
                                       FORMAT((balance_mora/last_balance)*100, 2) AS "indice_mora",
                                    	 FORMAT((balance_mora1/last_balance)*100, 2) AS "indice_mora1",
                                    	 FORMAT((balance_mora2/last_balance)*100, 2) AS "indice_mora2",
                                    	 FORMAT((balance_mora3/last_balance)*100, 2) AS "indice_mora3"
                                FROM (SELECT @prm_gestion := "2018", @prm_client_type := "FINANCIAL") alias, vw_delay
                                ORDER BY period');

        switch ($period_open-1) {
            case 1:   $period_name = "ENE"; break;
            case 2:   $period_name = "FEB"; break;
            case 3:   $period_name = "MAR"; break;
            case 4:   $period_name = "ABR"; break;
            case 5:   $period_name = "MAY"; break;
            case 6:   $period_name = "JUN"; break;
            case 7:   $period_name = "JUL"; break;
            case 8:   $period_name = "AGO"; break;
            case 9:   $period_name = "SEP"; break;
            case 10:   $period_name = "OCT"; break;
            case 11:   $period_name = "NOV"; break;
            case 12:   $period_name = "DIC"; break;
            default:   $period_name = "DIC"; $gestion_open = $gestion_open - 1; break;
        }

        return view('home', compact('pie_prop', 'bar_prop', 'pie_finan', 'bar_finan', 'gestion_open', 'period_name'));
    }
}
