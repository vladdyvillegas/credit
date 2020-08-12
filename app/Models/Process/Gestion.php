<?php

namespace Credit\Models\Process;

use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    //
    protected $table = 'gestion';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'gestion',
        'status'
    ];

}
