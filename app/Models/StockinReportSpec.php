<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockinReportSpec extends Model
{
    protected $table = 'stockin_report_spec';
    protected $fillable = ['sid', 'stockin_date', 'qty'];
    public $timestamps = false;
}
