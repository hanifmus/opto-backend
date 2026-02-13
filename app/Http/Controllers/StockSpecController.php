<?php

namespace App\Http\Controllers;

use App\Models\StockSpec;
use Illuminate\Http\Request;

class StockSpecController extends Controller
{
    public function index()
    {
        return StockSpec::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'framemodel' => 'required|string',
            'brand' => 'required|string',
            'color' => 'string',
            'size' => 'string',
            'frameType' => 'string',
            'material' => 'string',
            'qty' => 'required|integer|min:0'
        ]);

        // Auto-generate sid
        $lastRecord = StockSpec::orderBy('sid', 'desc')->first();
        if ($lastRecord && $lastRecord->sid) {
            // Extract numeric part from sid (e.g., "sid050" -> 50)
            $lastNum = intval(substr($lastRecord->sid, 3));
            $nextNum = $lastNum + 1;
        } else {
            $nextNum = 1;
        }
        $validated['sid'] = 'sid' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return StockSpec::create($validated);
    }

    public function show($sid)
    {
        return StockSpec::where('sid', $sid)->firstOrFail();
    }

    public function update(Request $request, $sid)
    {
        $stock = StockSpec::where('sid', $sid)->firstOrFail();
        
        $validated = $request->validate([
            'sid' => 'string',
            'framemodel' => 'string',
            'brand' => 'string',
            'color' => 'string|nullable',
            'size' => 'string|nullable',
            'frameType' => 'string|nullable',
            'material' => 'string|nullable',
            'qty' => 'integer|min:0'
        ]);

        // Remove sid from validated to avoid re-setting the primary key
        unset($validated['sid']);

        $stock->update($validated);
        return $stock;
    }

    public function destroy($sid)
    {
        $stock = StockSpec::where('sid', $sid)->firstOrFail();
        $stock->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
