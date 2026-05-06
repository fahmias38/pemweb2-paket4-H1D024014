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
        $query = Order::with(['customer', 'receivedBy']);

        if ($request->filled('search')) {
            $query->where('order_code', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('orders.create', compact('customers', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_code' => 'required|string|unique:orders,order_code|max:20',
            'customer_id' => 'required|exists:customers,id',
            'received_at' => 'required|date',
            'status' => 'required|in:diterima,dicuci,dikeringkan,disetrika,siap_diambil,selesai',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.weight' => 'required|numeric|min:0.1',
        ]);

        $total_weight = 0;
        $total_amount = 0;
        $max_duration = 0;
        $order_items = [];

        foreach ($validated['items'] as $item) {
            $service = Service::find($item['service_id']);
            $price = $service->is_express ? $service->price_per_kg * 1.5 : $service->price_per_kg;
            $subtotal = $item['weight'] * $price;
            
            $total_weight += $item['weight'];
            $total_amount += $subtotal;
            if ($service->duration_days > $max_duration) {
                $max_duration = $service->duration_days;
            }

            $order_items[] = new OrderItem([
                'service_id' => $service->id,
                'weight' => $item['weight'],
                'price_per_kg' => $price,
                'subtotal' => $subtotal,
            ]);
        }

        $estimated_finish_date = Carbon::parse($validated['received_at'])->addDays($max_duration);

        $order = Order::create([
            'order_code' => $validated['order_code'],
            'customer_id' => $validated['customer_id'],
            'received_by' => auth()->id(),
            'received_at' => $validated['received_at'],
            'estimated_finish_date' => $estimated_finish_date,
            'total_weight' => $total_weight,
            'total_amount' => $total_amount,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        $order->items()->saveMany($order_items);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'receivedBy', 'items.service']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('items');
        $customers = Customer::all();
        $services = Service::all();
        return view('orders.edit', compact('order', 'customers', 'services'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'order_code' => 'required|string|max:20|unique:orders,order_code,' . $order->id,
            'customer_id' => 'required|exists:customers,id',
            'received_at' => 'required|date',
            'status' => 'required|in:diterima,dicuci,dikeringkan,disetrika,siap_diambil,selesai',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.weight' => 'required|numeric|min:0.1',
        ]);

        $total_weight = 0;
        $total_amount = 0;
        $max_duration = 0;
        $order_items = [];

        foreach ($validated['items'] as $item) {
            $service = Service::find($item['service_id']);
            $price = $service->is_express ? $service->price_per_kg * 1.5 : $service->price_per_kg;
            $subtotal = $item['weight'] * $price;
            
            $total_weight += $item['weight'];
            $total_amount += $subtotal;
            if ($service->duration_days > $max_duration) {
                $max_duration = $service->duration_days;
            }

            $order_items[] = new OrderItem([
                'service_id' => $service->id,
                'weight' => $item['weight'],
                'price_per_kg' => $price,
                'subtotal' => $subtotal,
            ]);
        }

        $estimated_finish_date = Carbon::parse($validated['received_at'])->addDays($max_duration);

        $order->update([
            'order_code' => $validated['order_code'],
            'customer_id' => $validated['customer_id'],
            'received_at' => $validated['received_at'],
            'estimated_finish_date' => $estimated_finish_date,
            'total_weight' => $total_weight,
            'total_amount' => $total_amount,
            'status' => $validated['status'],
            'notes' => $validated['notes'],
        ]);

        $order->items()->delete();
        $order->items()->saveMany($order_items);

        return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
