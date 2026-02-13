<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockContact extends Model
{
    protected $table = 'stock_contact';
    protected $primaryKey = 'cid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'cid', 'brand', 'power', 'category', 'baseCurve', 'diameter', 'expiryDate', 'qty'
    ];
}
