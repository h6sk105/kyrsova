<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\Flight;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaceOrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        $flight_id = $request->input('flightid');
        $seat_count = $request->input('seatcount');
        $flight = Flight::find($flight_id);

        if ($flight->free_space < $seat_count) {
            return back()->with('error', 'Not enough seats available. Only ' . $flight->free_space . ' left.');
        }

        if ($flight->free_space == 0) {
            return back()->with('error', 'No available seats for this flight.');
        }



        $order = new Order();
        $order->flight_id = $flight_id;
        $order->user_id = Auth::user()->id;
        $order->email = $request->input('email');
        $order->seat_count = $seat_count;

        $order->save();

        $flight->free_space -= $seat_count;
        $flight->save();

        return to_route('data-table-flights')->with('success', 'Order placed successfully.');
    }


    private function getMyOrders(): array
    {
        $id = Auth::user()->id;

        $orders = Order::where('user_id', $id)->get();

        $rows_orders = $orders->map(function ($order) {

            return [
                $order->flight_id,
                $order->seat_count,
                $order->email
            ];
        });


        $headers_orders = ['flight id', 'seat count', 'email'];
        $names = $this->removeSpacesFromWorld($headers_orders);
        $table = 'orders';

        return compact('rows_orders', 'headers_orders', 'table', 'names');
    }

    public function showMyOrders()
    {
        return view('data-table', $this->getMyOrders());
    }

}
