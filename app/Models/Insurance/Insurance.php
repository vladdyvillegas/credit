<?php

namespace Credit\Models\Insurance;

use Illuminate\Database\Eloquent\Model;

class Insurance extends Model
{
    protected $table = 'insurances';
    protected $fillable = [
        'payment',
        'payment_date'
    ];

    public function operation()
    {
        return $this->belongsTo('\Credit\Models\Operation\Operation');
    }
}
