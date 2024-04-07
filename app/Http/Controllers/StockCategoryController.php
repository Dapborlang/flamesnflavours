<?php

namespace App\Http\Controllers;

use App\Models\StockCategory;
use Illuminate\Http\Request;

class StockCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = StockCategory::all();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'closing_balance' => 'nullable|numeric' // Closing balance is now nullable and numeric
        ]);

        $category = StockCategory::create($validatedData);

        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'closing_balance' => 'nullable|numeric' // Closing balance is now nullable and numeric
        ]);

        $category = StockCategory::findOrFail($id);
        $category->update($validatedData);

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = StockCategory::findOrFail($id);
        $category->delete();

        return response()->json(null, 204);
    }
}