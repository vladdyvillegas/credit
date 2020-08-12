<?php

namespace Credit\Models\Dim;

use Illuminate\Database\Eloquent\Model;

class DimCreditReport extends Model
{
    //
    protected $table = 'dim_credit_report';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'gestion',
        'period',
        'operation_id',
        'operation',
        'client_id',
        'client',
        'client_type',
        'first_date',
        'last_date',
        'capital',
        'interest',
        'interest_late',
        'ubicar',
        'assure',
        'charges',
        'disgrace',
        'last_balance',
        'fee_delayed',
        'fee_plan_num',
        'fee_plan_den',
        'pay_plan'
    ];

}
