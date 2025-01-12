<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Pilot extends Model
{
    public static function isPilot()
    {
        $userEmail = Auth::user()->email;

        if (Pilot::where('email', $userEmail)->first()) {
            return true;
        };

        return false;
    }
}
