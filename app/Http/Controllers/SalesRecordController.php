<?php

namespace App\Http\Controllers;

use App\Models\SalesRecordSpec;
use App\Models\SalesRecordContact;
use Illuminate\Http\Request;

class SalesRecordController extends Controller
{
    public function indexSpec()
    {
        return SalesRecordSpec::all();
    }

    public function indexContact()
    {
        return SalesRecordContact::all();
    }

    public function storeSpec(Request $request)
    {
        $validated = $request->validate([
            'sid' => 'required|string|exists:stock_spec,sid',
            'qty' => 'required|integer|min:1',
            'stockout_date' => 'required|date',
            'reason' => 'string'
        ]);

        return SalesRecordSpec::create($validated);
    }

    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'cid' => 'required|string|exists:stock_contact,cid',
            'qty' => 'required|integer|min:1',
            'stockout_date' => 'required|date',
            'reason' => 'string'
        ]);

        return SalesRecordContact::create($validated);
    }
}
