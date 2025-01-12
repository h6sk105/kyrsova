<?php

namespace App\Http\Controllers;

use App\Mail\FlightCancellationMail;
use App\Models\flight;
use App\Models\City;
use App\Models\Order;
use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;


class FlightController extends Controller
{

    public function index(): View
    {
        return view('table', $this->getFormattedFlightsData());
    }

    public function datatable(): View
    {
        return view('data-table', $this->getFormattedFlightsData());
    }

    private function getFormattedFlightsData(?int $id = null): array
    {
        if ($id) {

            $flight = Flight::find($id);;
            $rows_flights = [[$flight->id,
                $flight->aircraft_id,
                $flight->pilot_id,
                $flight->departure_city_id,
                $flight->arrival_city_id,
                $flight->departure_date,
                $flight->arrival_date,
                $flight->price,
                $this->switchStatus($flight->status),
                $flight->free_space]];
        } else {

            $flights = Flight::all();
            $rows_flights = $flights->map(function ($flight) {

                return [
                    $flight->id,
                    $flight->aircraft_id,
                    $flight->pilot_id,
                    $flight->departure_city_id,
                    $flight->arrival_city_id,
                    $flight->departure_date,
                    $flight->arrival_date,
                    $flight->price,
                    $this->switchStatus($flight->status),
                    $flight->free_space,
                ];
            });
        }

        $headers_flights = [
            'id',
            'aircraft id',
            'pilot id',
            'departure city id',
            'arrival city id',
            'departure date',
            'arrival date',
            'price',
            'status',
            'free space'
        ];
        $names = $this->removeSpacesFromWorld($headers_flights);
        $table = 'flights';

        return compact('rows_flights', 'headers_flights', 'table', 'names');
    }

    public function edit(int $id): View
    {
        return view('edit-table', $this->getFormattedFlightsData($id));
    }

    public function update(Request $request)
    {
        $flight = Flight::find($request->input('id'));

        $wasActive = $flight->status;
        $this->fillFlightData($flight, $request);

        if ($wasActive && $flight->status == false) {

            $this->notifyCancellation($flight);
        }
        $flight->save();

        return to_route('flight-table');
    }

    public function add(Request $request)
    {
        $flight = new Flight();
        $this->fillFlightData($flight, $request);
        $flight->save();

        return to_route('flight-table');
    }

    private function notifyCancellation(Flight $flight)
    {
        $orders = Order::where('flight_id', $flight->id)->get();
        $departure_city_name = City::where('id', $flight->departure_city_id)->first()->name;
        $arrival_city_name = City::where('id', $flight->arrival_city_id)->first()->name;

        foreach ($orders as $order) {
            $user = $order->user;
            $name = $user->name;

            Mail::to($order->email)->send(new FlightCancellationMail($name, $flight, $departure_city_name, $arrival_city_name));
        }
    }


    private function fillFlightData(Flight $flight, Request $request)
    {
        $flight->aircraft_id = $request->input('aircraftid');
        $flight->pilot_id = $request->input('pilotid');
        $flight->departure_city_id = $request->input('departurecityid');
        $flight->arrival_city_id = $request->input('arrivalcityid');
        $flight->departure_date = $request->input('departuredate');
        $flight->arrival_date = $request->input('arrivaldate');
        $flight->price = $request->input('price');
        $flight->status = $this->switchStatus($request->input('status'));
    }

    public function delete(int $id)
    {
        Flight::destroy($id);

        return to_route('flight-table');
    }

}
