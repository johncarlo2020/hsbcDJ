<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\StationUser;

class StationController extends Controller
{
    public function index(Station $station)
    {
        $user = StationUser::where('user_id',auth()->id())->where('station_id',$station->id)->exists();

        return view('station',compact('station','user'));
    }

    public function welcome()
    {
        $stations = Station::all();
        return view('dashboard',compact('stations'));
    }
}
