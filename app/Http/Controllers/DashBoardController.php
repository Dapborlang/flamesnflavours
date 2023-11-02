<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function dailySale()
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(6); 

        $dailySales = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as totalSales'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();

        return response()->json($dailySales);
    }
}
