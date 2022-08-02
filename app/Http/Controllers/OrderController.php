<?php

namespace App\Http\Controllers;

use App\Models\Key;
use App\Models\Order;
use App\Models\Technician;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;

use function GuzzleHttp\Promise\all;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('orderBy') && $request->input('sort')) {
            $orderBy = $request->input('orderBy');
            $sortBy = $request->input('sort');
            switch ($orderBy) {
                case 'key':
                    $orders = Order::join('keys', 'keys.id', 'orders.key_id')
                        ->orderBy('keys.name',  $sortBy);
                    break;
                
                case 'vehicle':
                    $orders = Order::join('vehicles', 'vehicles.id', 'orders.vehicle_id')
                        ->orderBy('vehicles.model',  $sortBy);
                    break;
                
                case 'technician':
                    $orders = Order::join('technicians', 'technicians.id', 'orders.technician_id')
                        ->orderBy('technicians.last_name', $sortBy)
                        ->orderBy('technicians.first_name', $sortBy);
                    break;
                
                default:
                    $orders = Order::orderByDesc('created_at')->all();
                    break;
            }
            $orders = $orders->get();
            $sortBy = $sortBy == 'asc' ? 'desc' : 'asc';
        } else {
            $orders = Order::all();
            $orderBy = null;
            $sortBy = null;
        }

        return view('order.index', [
            'orders' => $orders,
            'orderBy' => $orderBy,
            'sortBy' => $sortBy,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keys = Key::all();
        $vehicles = $keys[0]->vehicles;

        return view('order.create', [
            'keys' => $keys,
            'vehicles' => $vehicles,
            'technicians' => Technician::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required',
            'vehicle' => 'required',
            'technician' => 'required',
        ]);

        $order = new Order();

        $order->key_id = $validated['key'];
        $order->vehicle_id = $validated['vehicle'];
        $order->technician_id = $validated['technician'];

        try {
            $order->save();

            return redirect()
                ->route('orders.index');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('order.show', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $keys = Key::all();
        $vehicles = $order->key->vehicles;
        $technicians = Technician::all();
        return view('order.edit', [
            'order' => $order,
            'keys' => $keys,
            'vehicles' => $vehicles,
            'technicians' => $technicians,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'key' => 'required',
            'vehicle' => 'required',
            'technician' => 'required',
        ]);

        $order->key_id = $validated['key'];
        $order->vehicle_id = $validated['vehicle'];
        $order->technician_id = $validated['technician'];

        try {
            $order->save();

            return redirect()
                ->route('orders.index');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors([$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()
                ->route('orders.index');
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors([$e->getMessage()]);
        }
    }

    public function getVehicleByKey(Key $key)
    {
        return response()->json($key->vehicles);
    }
}
