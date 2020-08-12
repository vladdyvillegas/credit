<?php

namespace Credit\Models\Process;

use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    //
    protected $table = 'period';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'gestion',
        'period',
        'name',
        'status'
    ];

}
