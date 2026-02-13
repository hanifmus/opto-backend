<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesRecordSpec extends Model
{
    protected $table = 'sales_record_spec';
    protected $fillable = ['sid', 'stockout_date', 'qty', 'reason'];
    public $timestamps = false;
}
