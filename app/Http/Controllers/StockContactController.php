<?php

namespace App\Http\Controllers;

use App\Models\StockContact;
use Illuminate\Http\Request;

class StockContactController extends Controller
{
    public function index()
    {
        return StockContact::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string',
            'power' => 'required|string',
            'category' => 'string',
            'baseCurve' => 'string',
            'diameter' => 'string',
            'expiryDate' => 'nullable|date',
            'qty' => 'required|integer|min:0'
        ]);

        // Auto-generate cid
        $lastRecord = StockContact::orderBy('cid', 'desc')->first();
        if ($lastRecord && $lastRecord->cid) {
            // Extract numeric part from cid (e.g., "cid050" -> 50)
            $lastNum = intval(substr($lastRecord->cid, 3));
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }
        $validated['cid'] = 'cid' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return StockContact::create($validated);
    }

    public function show($cid)
    {
        return StockContact::where('cid', $cid)->firstOrFail();
    }

    public function update(Request $request, $cid)
    {
        $stock = StockContact::where('cid', $cid)->firstOrFail();
        
        $validated = $request->validate([
            'cid' => 'string',
            'brand' => 'string|nullable',
            'power' => 'string|nullable',
            'category' => 'string|nullable',
            'baseCurve' => 'string|nullable',
            'diameter' => 'string|nullable',
            'expiryDate' => 'nullable|date',
            'qty' => 'integer|min:0'
        ]);

        // Remove cid from validated to avoid re-setting the primary key
        unset($validated['cid']);

        $stock->update($validated);
        return $stock;
    }

    public function destroy($cid)
    {
        $stock = StockContact::where('cid', $cid)->firstOrFail();
        $stock->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
