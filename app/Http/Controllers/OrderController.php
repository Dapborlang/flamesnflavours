<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
 
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $orders = Order::with('items')
        ->whereDate('created_at',$date)
        ->get(); 
        return response()->json($orders);
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
        $order->save();

        foreach ($request->items as $item) {
            $orderItem=new OrderItem();
            $orderItem->order_id= $order->id;
            $orderItem->menu_item_id= $item['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->amount=$item['rate'];
            $orderItem->save();
        }


    
        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }

    public function show(Order $order)
    {
        $order->load('items.menuItem'); 
        return view('order.summary', compact('order'));
    }

    public function showPendingOrders()
    {
        return view('order.pending');
    }

    public function getOrdersByStatus()
    {
        $orders = Order::orderBy('id','desc')
        ->whereDate('created_at',now()->toDateString())
        ->get();
        $orders->load('items.menuItem');
        foreach($orders as $items)
        {
            $data[$items->status][]=$items;
        }
        return $data;
    }

    public function processOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'processing']);
        return response()->json(['message' => 'Order processed successfully']);
    }

    public function completeOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->status = 'Completed';
        $order->save();
        return response()->json(['message' => 'Order completed successfully']);
    }

    public function getOrdersDetail(Order $order)
    {
        $order->load('items.menuItem'); 
        return $order;
    }

    public function printReceipt($id)
    {
        $order=OrderItem::where('order_id',$id)
        ->get();
        return view('order.print', compact('order','id'));
    }    
}
