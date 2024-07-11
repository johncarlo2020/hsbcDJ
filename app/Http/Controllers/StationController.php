<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Station;
use App\Models\User;

use App\Models\StationUser;
use DB;
use Auth;
use Carbon\Carbon;
class StationController extends Controller
{
    public function index(Station $station)
    {
        $user = StationUser::where('user_id',auth()->id())->where('station_id',$station->id)->exists();

        return view('station',compact('station','user'));
    }

    public function welcome()
    {
        $user = User::with('stationUser')->where('id', auth()->id())->first();
        // dd($user->stationUser->count());

        $stationDone = $user->stationUser->count();
        $stations = Station::get();

        // Loop through each station and append a flag indicating if the user has it
        foreach ($stations as $station) {
            $userHasStation = $user->StationUser()->where('station_id', $station->id)->exists();
            $station->status = $userHasStation;
        }

        return view('dashboard',compact('stations','stationDone'));
    }
    

    public function scan(Request $request)
    {
        // Parse the URL to get the query string
 

        $qrCodeMessage = trim($request->qrCodeMessage);

        // Get the last character of the QR code message
        $station_id = substr($qrCodeMessage, -1);

    // Assume that `$station_id` is validated before this point

    try {
        DB::beginTransaction();

        if($station_id != $request->station){
            return response()->json(['message' => 'Invalid Qr','status'=>'error'], 401);
        }

        $lastStation = StationUser::where('user_id', auth()->id())->orderBy('id','desc')->first();

        if(empty($lastStation)){
            $lastLoginTime = Auth::user()->last_login_at;
            $currentDateTime = Carbon::now();
            $timeSpent = $currentDateTime->diff($lastLoginTime);
            $minutesSpent = $timeSpent->i; // Minutes spent
            $secondsDifference = $timeSpent->s; // Seconds

            // Convert minutes to seconds
            $secondsSpent = ($minutesSpent * 60)+$secondsDifference;
        }else{
            $lastLoginTime = $lastStation->created_at;
            $currentDateTime = Carbon::now();
            $timeSpent = $currentDateTime->diff($lastLoginTime);
            $minutesSpent = $timeSpent->i; // Minutes spent
            $secondsDifference = $timeSpent->s; // Seconds
            // Convert minutes to seconds
            $secondsSpent = ($minutesSpent * 60)+$secondsDifference;

        }

        $stationUser = new StationUser;
        $stationUser->user_id = auth()->id();
        $stationUser->station_id = $station_id;
        $stationUser->time_spent = $secondsSpent;
        $stationUser->save();
        DB::commit();
        // Success response
        return response()->json(['message' => 'Station ID updated successfully'], 200);
    } catch (\Exception $e) {
        DB::rollback();

        // Handle the error, log it, or return an appropriate response
        return response()->json(['error' => $e,], 500);
    }

    }
}
