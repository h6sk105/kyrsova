<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TakeFlightController extends Controller
{
    public function takeFlight(Request $request)
    {

        $pilot = Pilot::where('email', Auth::user()->email)->first();

        if (!$pilot) {
            return back()->with('error', 'Pilot not found.');
        }

        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $flightsCount = Flight::where('pilot_id', $pilot->id)
            ->whereBetween('departure_date', [$startOfWeek, $endOfWeek])
            ->count();

        if ($flightsCount >= 4) {
            return back()->with('error', 'You have already taken 4 flights this week. You cannot take more.');
        }

        $flight = new Flight();
        $flight->pilot_id = $pilot->id;
        $flight->aircraft_id = $request->input('aircraftid');
        $flight->departure_city_id = $request->input('departurecityid');
        $flight->arrival_city_id = $request->input('arrivalcityid');
        $flight->departure_date = $request->input('departuredate');
        $flight->arrival_date = $request->input('arrivaldate');
        $flight->price = $request->input('price');

        $flight->save();

        return to_route('data-table-flights')->with('success', 'Flight taken successfully.');
    }

}
