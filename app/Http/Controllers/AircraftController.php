<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AircraftController extends Controller
{

    public function index(): View
    {
        return view('table', $this->getFormattedAircraftData());
    }

    public function edit($id)
    {
        return view('edit-table', $this->getFormattedAircraftData($id));
    }

    public function datatable(): View
    {
        return view('data-table', $this->getFormattedAircraftData());
    }


    private function getFormattedAircraftData($id = null): array
    {

        if ($id) {
            $aircraft = Aircraft::find($id);
            $rows_aircraft = [[$aircraft->id, $aircraft->model, $aircraft->seat_count, $this->switchStatus($aircraft->status)]];
        } else {
            $aircraft = Aircraft::all();
            $rows_aircraft = $aircraft->map(function ($item) {
                return [$item->id, $item->model, $item->seat_count, $this->switchStatus($item->status)];
            });
        }

        $headers_aircraft = ['id', 'model', 'seat count', 'status'];
        $names = $this->removeSpacesFromWorld($headers_aircraft);
        $table = 'aircraft';

        return compact('rows_aircraft', 'headers_aircraft', 'table', 'names');
    }

    public function update(Request $request)
    {
        $aircraft = Aircraft::find($request->input('id'));
        $this->fillAircraftData($aircraft, $request);
        $aircraft->save();

        return to_route('aircraft-table');
    }

    public function add(Request $request)
    {
        $aircraft = new Aircraft();
        $this->fillAircraftData($aircraft, $request);
        $aircraft->save();

        return to_route('aircraft-table');
    }

    private function fillAircraftData(Aircraft $aircraft, Request $request)
    {
        $aircraft->model = $request->input('model');
        $aircraft->seat_count = $request->input('seatcount');
        $aircraft->status = $this->switchStatus($request->input('status'));
    }

    public function delete($id)
    {
        Aircraft::destroy($id);

        return to_route('aircraft-table');
    }

}
