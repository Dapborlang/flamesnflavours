<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        
    }

    public function create()
    {
        return view('order.create');
    }


    public function store(Request $request)
    {
        $order = new Order();
        $order->table_id = 1; 
        $order->status = 'pending'; 
        $order->total_amount=1000;
        $order->save();

        foreach ($request->items as $item) {
            $orderItem=new OrderItem();
            $orderItem->order_id= $order->id;
            $orderItem->menu_item_id= $item['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->save();
        }
    
        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }


    public function show(Order $order)
    {

    }

    public function edit(Order $order)
    {
      
    }

    public function update(Request $request, Order $order)
    {
        
    }

    public function destroy(Order $order)
    {
        
    }

    public function showOrderSummary(Order $order)
    {
        $order->load('items.menuItem'); 
        return view('order.summary', compact('order'));
    }
}
