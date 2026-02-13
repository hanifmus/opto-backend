<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockinReportContact extends Model
{
    protected $table = 'stockin_report_contact';
    protected $fillable = ['cid', 'stockin_date', 'qty'];
    public $timestamps = false;
}
