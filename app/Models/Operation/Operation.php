<?php

namespace Credit\Models\Operation;

use DB;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    //
    protected $table = 'operations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'operation',
        'requested_date',
        'application_date',
        'client_id',
        'product_id',
        'amount',
        'product_price',
        'own_input',
        'monthly_term',
        'payment_term',
        'annual_interest_rate',
        'delayed_interest_rate',
        'disgrace_insurance_rate',
        'service_1',
        'service_2'
    ];

    public static function query_report($gestion, $date_report, $type)
    {
        return DB::table('operations')
                      ->join('payments', 'operations.id', '=', 'payments.operation_id')
                      ->join('clients', 'operations.client_id', '=', 'clients.id')
                      ->select('operations.id as operation_id',
                              'operations.operation',
                              'clients.id as client_id',
                              'clients.name',
                              'clients.type as type',
                              'operations.dealer_id',
                              'operations.request_date',
                              'operations.application_date',
                              'operations.last_payment_date',
                              'operations.next_payment',
                              DB::raw('max(payments.payment) as payment'),
                              DB::raw('max(payments.expiration_date) as expiration_date'),
                              DB::raw('max(payments.payment_date) as payment_date'),
                              DB::raw('sum(payments.fixed_fee) as fixed_fee'),
                              DB::raw('sum(case when payments.gestion = '.$gestion.' then payments.interest else 0 end) as interest'),
                              DB::raw('sum(case when payments.gestion = '.$gestion.' then payments.interest_late else 0 end) as interest_late'),
                              DB::raw('sum(payments.capital) as capital'),
                              DB::raw('sum(payments.amortization_fee) as amortization_fee'),
                              DB::raw('sum(case when payments.gestion = '.$gestion.' then payments.assure else 0 end) as assure'),
                              DB::raw('sum(case when payments.gestion = '.$gestion.' then payments.ubicar else 0 end) as ubicar'),
                              DB::raw('sum(case when payments.gestion = '.$gestion.' then payments.charges else 0 end) as charges'),
                              DB::raw('sum(case when payments.gestion = '.$gestion.' then payments.disgrace else 0 end) as disgrace'),
                              DB::raw('min(payments.balance) as balance'),
                              'operations.amount',
                              'operations.service_1',
                              'operations.service_2',
                              'operations.last_balance',
                              'operations.monthly_term',
                              'operations.payment_term',
                              'operations.total_payment',
                              'operations.status')
                      ->where('payments.payment_date', '<=', $date_report)
                      ->whereIn('operations.status', ['PPG', 'REC', 'RES', 'LIT'])
                      ->groupBy('payments.operation_id')
                      ->having('clients.type', $type)
                      ->orderBy('operations.operation')
                      ->get();
    }

    public static function query_accrued_report($gestion, $date_report, $type)
    {
        return DB::table('operations')
                      ->join('payments', 'operations.id', '=', 'payments.operation_id')
                      ->join('clients', 'operations.client_id', '=', 'clients.id')
                      ->select('operations.id as operation_id',
                              'operations.operation',
                              'clients.name',
                              'clients.type as type',
                              DB::raw('max(payments.expiration_date) as expiration_date'),
                              DB::raw('max(payments.accrued_past_payment_date) as accrued_past_payment_date'),
                              DB::raw('sum(case when payments.gestion <= '.$gestion.' then payments.interest_accrued_past else 0 end) as interest_accrued_past'),
                              DB::raw('max(payments.accrued_past_voucher) as accrued_past_voucher'),
                              'operations.status')
                      ->where('payments.accrued_past_payment_date', '<=', $date_report)
                      ->groupBy('payments.operation_id')
                      ->having('clients.type', $type)
                      ->orderBy('operations.operation')
                      ->get();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->belongsTo('\Credit\Models\Client\Client');
    }

    public function product()
    {
        return $this->belongsTo('\Credit\Models\Product\Product');
    }

    public function dealer()
    {
        return $this->belongsTo('\Credit\Models\Classif\Dealer');
    }

    public function paymentplan()
    {
        return $this->hasMany('\Credit\Models\Operation\PaymentPlan');
    }

    public function insurances()
    {
        return $this->hasMany('\Credit\Models\Insurance\Insurance');
    }
}
