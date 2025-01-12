<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        return view('table', $this->getFormattedCitiesData());
    }

    public function datatable(): View
    {
        return view('data-table', $this->getFormattedCitiesData());
    }

    private function getFormattedCitiesData(?int $id = null): array
    {

        if ($id) {
            $city = City::find($id);
            $rows_cities = [[$city->id, $city->name, $city->country]];
        } else {
            $cities = City::all();
            $rows_cities = $cities->map(function ($city) {
                return [$city->id, $city->name, $city->country];
            });
        }

        $headers_cities = ['id', 'name', 'country'];
        $names = $this->removeSpacesFromWorld($headers_cities);
        $table = 'cities';

        return compact('rows_cities', 'headers_cities', 'table', 'names');
    }


    public function edit(int $id): View
    {
        return view('edit-table', $this->getFormattedCitiesData($id));
    }

    public function update(Request $request)
    {
        $city = City::find($request->input('id'));
        $this->fillCityData($city, $request);
        $city->save();

        return to_route('city-table');
    }

    public function add(Request $request)
    {
        $city = new City();
        $this->fillCityData($city, $request);
        $city->save();

        return to_route('city-table');
    }

    private function fillCityData(City $city, Request $request)
    {
        $city->name = $request->input('name');
        $city->country = $request->input('country');
    }


    public function delete(int $id)
    {
        City::destroy($id);

        return to_route('city-table');
    }

    public function showTopFiveVisitedCities()
    {

        $topCities = City::join('flights', 'cities.id', '=', 'flights.arrival_city_id')
            ->join('orders', 'flights.id', '=', 'orders.flight_id')
            ->selectRaw('cities.id, cities.name, COUNT(orders.id) as visit_count')
            ->groupBy('cities.id', 'cities.name')
            ->orderByDesc('visit_count')
            ->limit(5)
            ->get();

        return view('top-visited-cities', compact('topCities'));
    }


}
