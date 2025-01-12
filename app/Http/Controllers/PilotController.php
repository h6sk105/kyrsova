<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PilotController extends Controller
{

    public function index(): View
    {
        return view('table', $this->getFormattedPilotsData());
    }

    private function getFormattedPilotsData(?int $id = null): array
    {
        if ($id) {
            $pilot = Pilot::find($id);
            $rows_pilots = [[$pilot->id, $pilot->name, $pilot->email, $pilot->license_number, $pilot->flights]];
        } else {
            $pilots = Pilot::all();
            $rows_pilots = $pilots->map(function ($pilot) {
                return [$pilot->id, $pilot->name, $pilot->email, $pilot->license_number, $pilot->flights];
            });
        }

        $headers_pilots = ['id', 'name', 'email', 'license number', 'flights'];
        $names = $this->removeSpacesFromWorld($headers_pilots);
        $table = 'pilots';

        return compact('rows_pilots', 'headers_pilots', 'table', 'names');
    }


    public function edit(int $id): View
    {
        return view('edit-table', $this->getFormattedPilotsData($id));
    }

    public function update(Request $request)
    {
        $pilot = Pilot::find($request->input('id'));
        $this->fillPilotData($pilot, $request);
        $pilot->save();

        return to_route('pilot-table');
    }

    public function add(Request $request)
    {
        $pilot = new Pilot();
        $this->fillPilotData($pilot, $request);
        $pilot->save();

        return to_route('pilot-table');
    }

    private function fillPilotData(Pilot $pilot, Request $request)
    {
        $pilot->name = $request->input('name');
        $pilot->email = $request->input('email');
        $pilot->license_number = $request->input('licensenumber');
        $pilot->flights = $request->input('flights');
    }

    public function delete(int $id)
    {
        Pilot::destroy($id);

        return to_route('pilot-table');
    }



}
