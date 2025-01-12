<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{

    public function index(): View
    {
        return view('table', $this->getFormattedOrdersData());
    }

    private function getFormattedOrdersData(?int $id = null): array
    {

        if ($id) {
            $order = Order::find($id);
            $user = User::where('id', $order->user_id)->first();

            $rows_orders = [[$order->id, $order->flight_id, $order->user_id, $order->seat_count, $user->email]];
        } else {
            $orders = Order::all();
            $rows_orders = $orders->map(function ($order) {
                $user = User::where('id', $order->user_id)->first();
                return [
                    $order->id,
                    $order->flight_id,
                    $order->user_id,
                    $order->seat_count,
                    $user->email
                ];
            });
        }

        $headers_orders = ['id', 'flight id', 'user id', 'seat count', 'email'];
        $names = $this->removeSpacesFromWorld($headers_orders);
        $table = 'orders';

        return compact('rows_orders', 'headers_orders', 'table', 'names');
    }


    public function edit(int $id): View
    {
        return view('edit-table', $this->getFormattedOrdersData($id));
    }

    public function update(Request $request)
    {
        $order = Order::find($request->input('id'));
        $this->fillOrderData($order, $request);
        $order->save();

        return to_route('order-table');
    }

    public function add(Request $request)
    {
        $order = new Order();
        $this->fillOrderData($order, $request);
        $order->save();

        return to_route('order-table');
    }

    private function fillOrderData(Order $order, Request $request)
    {
        $order->flight_id = $request->input('flightid');
        $order->user_id = $request->input('userid');
        $order->seat_count = $request->input('seatcount');
        $order->email = $request->input('email');
    }


    public function delete(int $id)
    {
        Order::destroy($id);

        return to_route('order-table');
    }

}
