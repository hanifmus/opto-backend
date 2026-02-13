<?php

namespace App\Http\Controllers;

use App\Models\StockinReportSpec;
use App\Models\StockinReportContact;
use Illuminate\Http\Request;

class StockinReportController extends Controller
{
    public function storeSpec(Request $request)
    {
        $validated = $request->validate([
            'sid' => 'required|string|exists:stock_spec,sid',
            'qty' => 'required|integer|min:1',
            'stockin_date' => 'required|date'
        ]);

        return StockinReportSpec::create($validated);
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'cid' => 'required|string|exists:stock_contact,cid',
            'qty' => 'required|integer|min:1',
            'stockin_date' => 'required|date'
        ]);

        return StockinReportContact::create($validated);
    }

    public function indexSpec()
    {
        return StockinReportSpec::all();
    }

    public function indexContact()
    {
        return StockinReportContact::all();
    }
}
