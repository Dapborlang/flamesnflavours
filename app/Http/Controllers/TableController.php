<?php

namespace App\Http\Controllers;
use App\Models\TableNo;

use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $posts = TableNo::all();
        return $posts;
    }

    public function create()
    {
        // Show the form for creating a new post
        return view('table.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'table_number' => 'required|string',
        ]);

        $table = new TableNo();
        $table->table_number = $request->table_number;

        $table->save();

        // Return a response, e.g., a JSON response or a redirect
        return response()->json(['message' => 'Table created successfully', 'table' => $table]);
    }


    public function destroy($id)
    {
        $table = TableNo::find($id);

        if (!$table) {
            return response()->json(['message' => 'Table not found'], 404);
        }

        $table->delete();

        return response()->json(['message' => 'Table deleted successfully'], 200);
    }
}
