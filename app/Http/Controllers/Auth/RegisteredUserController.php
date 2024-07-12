<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Countries;
use App\Models\Regime;
use Carbon\Carbon;

use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Rules\InternationalPhoneNumber;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $options = Regime::all();
        return view('auth.register',compact('options'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fname' => ['required', 'string', 'max:255'],
            'lname' => ['required', 'string', 'max:255'],
            'age' => ['required'],
            'number' => ['required', 'string', new InternationalPhoneNumber],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        // After validation, fetch country by phone number
        $phoneNumber = $request->input('number');
      // Extract the phone prefix
$phonePrefix = '+' . substr($phoneNumber, 1, 2); // This assumes the prefix is always 2 characters after the '+'

// Query the country based on the phone prefix
$country = Countries::where('phone_code', $phonePrefix)->first();

        // dd($request);

        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'age_group' => $request->age,
            'number' => $request->number,
            'email' => $request->email,
            'country'=> $country->name,
            'last_login_at' => Carbon::now(),
            'password' => Hash::make('password'),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
