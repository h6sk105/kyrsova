<?php

namespace App\Http\Controllers;

use App\Models\Pilot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PilotAuthController extends Controller
{
    public function registerPilot(Request $request)
    {
        $pilot = new Pilot();

        $pilot->name = Auth::user()->name;
        $pilot->email = Auth::user()->email;
        $pilot->license_number = $request->input('license_number');
        $pilot->save();

        return to_route('dashboard');
    }

}
