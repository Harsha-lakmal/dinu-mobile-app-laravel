<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock ; 

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
            'stockNumber' => 'required|string|max:50|unique:stock,stockNumber',
            'subCategory_id' => 'required|integer',
        ]);

        Stock::create($request->all());

        return redirect()->route('stocks.index')->with('success', 'Stock created successfully!');
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
            'stockNumber' => 'required|string|max:50|unique:stock,stockNumber,' . $request->id,
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

   function fetch() {
        $stocks = Stock::all();
        return response()->json($stocks);
   }



    
}
