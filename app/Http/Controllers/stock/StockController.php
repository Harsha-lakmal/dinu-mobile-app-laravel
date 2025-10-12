<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'count' => 'required|integer',
            'desc' => 'nullable|string',
            'subCategory_id' => 'required|integer',
        ]);


        // Generate next stock number
        $lastStock = Stock::latest('id')->first();
        if ($lastStock) {
            // Get the last numeric part and increment
            $lastNumber = intval(substr($lastStock->stockNumber, 3)); // STK001 -> 1
            $newNumber = 'STK' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            // First record
            $newNumber = 'STK0001';
        }

        // Merge new stock number into request data
        $data = $request->all();
        $data['stockNumber'] = $newNumber;

        Stock::create($data);


        return response()->json([
            'success' => true,
            'message' => 'Stock created successfully!',
        ]);

        // return redirect()->route('stocks.index')->with('success', 'Stock created successfully!');
    }


    function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:stock,id',
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric',
            'count' => 'required|integer',
            'desc' => 'nullable|string',
            'subCategory_id' => 'required|integer',
        ]);


        $stock = Stock::find($request->id);
        if ($stock) {
            $stock->update($request->all());
            return response()->json(['success' => true, 'message' => 'Stock updated successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Stock not found!'], 404);
        }
    }
    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:stock,id',
        ]);

        $stock = Stock::find($request->id);
        if ($stock) {
            $stock->delete();
            return response()->json(['success' => true, 'message' => 'Stock deleted successfully!']);
        } else {
            return response()->json(['success' => false, 'message' => 'Stock not found!'], 404);
        }
    }

    public function fetch()
    {
        $stocks = Stock::orderBy('id', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $stocks
        ]);
    }
}
