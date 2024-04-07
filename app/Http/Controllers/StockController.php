<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\StockCategory;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = Stock::with('category')->paginate(10); 
        return response()->json($stocks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_category_id' => 'required|exists:stock_categories,id',
            'transaction' => 'required|in:credit,debit',
            'quantity' => 'required|numeric',
            'date' => 'required|date',
            'remark' => 'required',
        ]);

        $stockBalance=StockCategory::findOrFail($request->stock_category_id);
        if($request->transaction=='credit')
        {
            $balance=$stockBalance->closing_balance+$request->quantity;
            $stockBalance->closing_balance=$balance;
            $stockBalance->save();
        }
        else
        {
            $balance=$stockBalance->closing_balance-$request->quantity;
            $stockBalance->closing_balance=$balance;
            $stockBalance->save();
        }

        $stock = Stock::create([
            'stock_category_id' => $request->stock_category_id,
            'transaction' => $request->transaction,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'balance'=>$balance,
            'remark'=>$request->remark,
        ]);

        return response()->json($stock, 201);
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'stock_category_id' => 'required|exists:stock_categories,id',
            'transaction' => 'required|in:credit,debit',
            'quantity' => 'required|numeric',
            'date' => 'required|date',
            'remark' => 'required',
            'balance' => 'required',
        ]);

        $stock->update([
            'stock_category_id' => $request->stock_category_id,
            'transaction' => $request->transaction,
            'quantity' => $request->quantity,
            'date' => $request->date,
            'remark'=>$request->remark,
            'balance'=>$request->balance,
        ]);

        return response()->json($stock, 200);
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();

        return response()->json(null, 204);
    }

    public function registerView()
    {
        $stocks = Stock::orderBy('date')->get()->groupBy(function($date) {
            return Carbon::parse($date->date)->format('Y-m');
        });
        return view('stock.register', ['stocks' => $stocks]);
    }

}