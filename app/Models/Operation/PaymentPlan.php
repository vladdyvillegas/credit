<?php

namespace Credit\Models\Operation;

use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    //
    protected $table = 'payments';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'operation_id',
        'expiration_date',
        'payment_date',
        'fixed_fee',
        'interest',
        'capital',
        'assure',
        'ubicar',
        'charges',
        'disgrace',
        'variable_fee',
        'balance'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function operation()
    {
        return $this->belongsTo('\Credit\Models\Operation\Operation');
    }

}
