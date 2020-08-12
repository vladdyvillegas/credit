<?php

namespace Credit\Models\Classif;

use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    //
    protected $table = 'dealers';
    protected $primaryKey = 'id';

    protected $fillable = ['abbrev', 'dealer'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operation()
    {
        return $this->hasMany(Operation::class);
    }
}
