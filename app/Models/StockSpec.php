<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockSpec extends Model
{
    protected $table = 'stock_spec';
    protected $primaryKey = 'sid';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'sid',
        'framemodel',
        'brand',
        'color',
        'size',
        'frameType',
        'material',
        'qty'
    ];
}
