<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Service;
use App\Models\OrderItem;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::with(['customer', 'receivedBy'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('orders.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_code' => 'required|string|unique:orders,order_code|max:20',
            'customer_id' => 'required|exists:customers,id',
            'received_at' => 'required|date',
            'estimated_finish_date' => 'required|date',
            'total_weight' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:diterima,dicuci,dikeringkan,disetrika,siap_diambil,selesai',
            'notes' => 'nullable|string',
        ]);

        $validated['received_by'] = auth()->id();

        Order::create($validated);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'receivedBy']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $customers = Customer::all();
        return view('orders.edit', compact('order', 'customers'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_code' => 'required|string|max:20|unique:orders,order_code,' . $order->id,
            'customer_id' => 'required|exists:customers,id',
            'received_at' => 'required|date',
            'estimated_finish_date' => 'required|date',
            'total_weight' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:diterima,dicuci,dikeringkan,disetrika,siap_diambil,selesai',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
