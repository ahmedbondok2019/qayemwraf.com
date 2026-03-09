<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderService;
use Illuminate\Http\Request;

class OrderServiceController extends Controller
{
    public function index()
    {
        $services = OrderService::latest()->get();
        return view('dashboard.admin.order_services.index', compact('services'));
    }

    public function create()
    {
        return view('dashboard.admin.order_services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        OrderService::create([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.order_services.index')->with('success', trans_db('dashboard.saved'));
    }

    public function edit(OrderService $orderService)
    {
        return view('dashboard.admin.order_services.edit', compact('orderService'));
    }

    public function update(Request $request, OrderService $orderService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $orderService->update([
            'name' => $request->name,
            'name_ar' => $request->name_ar,
            'price' => $request->price,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.order_services.index')->with('success', trans_db('dashboard.updated'));
    }

    public function destroy(OrderService $orderService)
    {
        $orderService->delete();
        return redirect()->route('admin.order_services.index')->with('success', trans_db('dashboard.deleted'));
    }
}
