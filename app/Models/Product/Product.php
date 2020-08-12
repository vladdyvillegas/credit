<?php

namespace Credit\Models\Product;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'product',
        'name',
        'price',
        'annual_interest_rate',
        'delayed_interest_rate',
        'type'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operation()
    {
        return $this->hasMany(Operation::class);
    }
}
