<?php

namespace Credit\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    //
    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'client',
        'name',
        'birthdate',
        'civil_status',
        'email',
        'phone',
        'mobile_phone',
        'address',
        'profession',
        'legal_personality',
        'type_id_document',
        'id_document',
        'type',
        'work',
        'work_phone',
        'work_fax',
        'work_address',
        'work_activity',
        'spouse_name',
        'spouse_id_document',
        'spouse_phone',
        'spouse_email',
        'representative_name',
        'representative_id_document',
        'representative_phone',
        'representative_email'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operation()
    {
        return $this->hasMany(Operation::class);
    }
}
