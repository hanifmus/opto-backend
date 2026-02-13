<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesRecordContact extends Model
{
    protected $table = 'sales_record_contact';
    protected $fillable = ['cid', 'stockout_date', 'qty', 'reason'];
    public $timestamps = false;
}
