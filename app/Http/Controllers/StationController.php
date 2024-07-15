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

        if($stationDone < 6)
        {
            return view('dashboard',compact('stations','stationDone'));


        }else{
            return view('congrats');
        }

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

    public function admin()
    {
        $today = Carbon::today();
        $startDate = Carbon::create(2024, 7, 10);
        $data['users'] = User::with('stationUser')->take(4)->orderBy('id','desc')->get();
        $data['usersCount'] = User::whereDate('created_at', '>=', $startDate->toDateString())->count();
        $data['userToday'] = User::whereDate('created_at', $today)->count();
        $usersWithSixStationUsers = User::with('stationUser')->whereDate('created_at', '>=', $startDate->toDateString())->has('stationUser', '>=', 5)->count();
        // dd($usersWithSixStationUsers);
        $data['completedUsers'] = $usersWithSixStationUsers;
        // dd($usersWithSixStationUsers);

        if ($data['usersCount'] > 0) {
            $data['percentage'] = number_format(($usersWithSixStationUsers / $data['usersCount']) * 100, 2);

        } else {
            $data['percentage'] = 0; // Avoid division by zero
        }
        $userCounts = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->toArray();

        $userCountsArray = [];
        $data['dates'] = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date')
        )
        ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '>=', $startDate->toDateString())
        ->groupBy('date')
        ->get();


        //   dd($data['where']);


        $data['registrationsPerHour'] = User::select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as date'),
            DB::raw('CONCAT(
                CASE WHEN (DATE_FORMAT(created_at, "%H") + 8) % 12 = 0 THEN 12 ELSE (DATE_FORMAT(created_at, "%H") + 8) % 12 END,
                IF((DATE_FORMAT(created_at, "%H") + 8) >= 12, "pm", "am")
            ) as hour'),



            DB::raw('COUNT(*) as registrations')
        )
        ->where(DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d")'), '>=', $startDate->toDateString())

        ->groupBy('date', 'hour')
        ->get()
        ->groupBy('date');
        //  dd($data);

        foreach ($userCounts as $userCount) {
            if($userCount['date'] >= $startDate->toDateString())
            $userCountsArray[$userCount['date']] = $userCount['count'];
        }
        $data['usersDaily'] = $userCountsArray;
        // $completed = StationUser::w

        $averageTimespentByStation = StationUser::select('station_id', \DB::raw('AVG(time_spent) as average_timespent'))
            ->groupBy('station_id')
            ->get()
            ->keyBy('station_id');


        $stations = Station::pluck('name', 'id');

        $count = 0;

        foreach ($data['users'] as $user) {
            $userStations = $user->stationUser->pluck('station_id')->toArray();
            $numStations = count($userStations);

            $user->stations = $stations->map(function ($name, $id) use ($userStations, $averageTimespentByStation) {

                return [
                    'name' => $name,
                    'value' => in_array($id, $userStations),
                ];
            });
        }

        $data['stations'] = $stations->map(function ($name, $id) use ($userStations, $averageTimespentByStation) {
            return [
                'name' =>$name,
                'average_timespent' => number_format(($averageTimespentByStation->get($id)['average_timespent'] ?? 0) / 60, 2)

            ];
        });

        $averagePlaytimeByUser = StationUser::select('user_id', DB::raw('SUM(time_spent) / 60 as total_playtime'))
        ->groupBy('user_id')
        ->get();


        $totalAveragePlaytime = $averagePlaytimeByUser->avg('total_playtime');
        // dd($totalAveragePlaytime);
                //dd($data['users'][0]['stations']);
                //  dd($data);



        return view('dashboardadmin',compact('data'));
    }
    public function users()
    {
        $today = Carbon::today();
        $startDate = Carbon::create(2024, 5, 24);
        $data['users'] = User::whereDate('created_at', '>=', $startDate->toDateString())->with('stationUser')->orderBy('id','desc')->get();



        $averageTimespentByStation = StationUser::select('station_id', \DB::raw('AVG(time_spent) as average_timespent'))
            ->groupBy('station_id')
            ->get()
            ->keyBy('station_id');

        $stations = Station::pluck('name', 'id');

        foreach ($data['users'] as $user) {
            $userStations = $user->stationUser->pluck('station_id')->toArray();
            $user->stations = $stations->map(function ($name, $id) use ($userStations, $averageTimespentByStation) {

                return [
                    'name' => $name,
                    'value' => in_array($id, $userStations),
                ];
            });
        }

        $data['stations'] = $stations->map(function ($name, $id) use ($userStations, $averageTimespentByStation) {
            return [
                'name' =>$name,
                'average_timespent' => number_format(($averageTimespentByStation->get($id)['average_timespent'] ?? 0) / 60, 2)

            ];
        });
        //dd($data['users'][0]['stations']);
        //  dd($data);



        return view('users',compact('data'));

    }

    public function userData(User $user)
    {
        $user = User::find($user);

        $averagePlaytimeByUser = StationUser::where('user_id',$user[0]->id)
        ->avg('time_spent');

        $stations = Station::pluck('name', 'id');

        $averageTimespentByStation = StationUser::where('user_id',$user[0]->id)->orderBy('id','asc')->get();
        $total = StationUser::where('user_id',$user[0]->id)->orderBy('id','asc')->sum('time_spent');
        $totalMinutes = $total/60;
        $totalMinutes = number_format($totalMinutes, 2);

        foreach ($user as $userdata) {
            $userStations = $userdata->stationUser->pluck('station_id')->toArray();
            $numStations = count($userStations);

            $userdata->stations = $stations->map(function ($name, $id) use ($userStations,$user) {
                $spent = StationUser::where('user_id',$user[0]->id)->where('station_id',$id)->first();
                if(!$spent){
                    $minute = 0;

                }else{
                    $seconds = $spent->time_spent;
                    $minute = $seconds/60;
                    $minute = number_format($minute, 2);

                }
                return [
                    'name' => $name,
                    'value' => in_array($id, $userStations),
                    'time_spent'=>$minute,
                    'id'    => $id
                ];
            });
        }

        return view('userData',compact('user','totalMinutes'));
    }

    public function check(Request $request)
    {
        $check = StationUser::where('user_id',$request->user_id)->where('station_id',$request->station_id)->first();

        if(!$check){
            $stationUser = new StationUser;
            $stationUser->user_id = $request->user_id;
            $stationUser->station_id = $request->station_id;
            $stationUser->time_spent = 60;
            $stationUser->save();
        }else{
            $check->delete();
        }

        return $check;
    }
}
