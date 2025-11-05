<?php

namespace App\Http\Controllers\report;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    function getAll() {

       $data = DB::table('stock')
        ->leftJoin('sub_categories', 'stock.subCategory_id', '=', 'sub_categories.id')
        ->leftJoin('categories', 'sub_categories.categoires_id', '=', 'categories.id')
        ->select(
            'stock.*',
            'sub_categories.sub_title as sub_category_name',
            'categories.title as category_name'
        )
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $data
    ]);
        
    }
}

