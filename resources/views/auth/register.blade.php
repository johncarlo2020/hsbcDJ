<x-guest-layout>
<h1>Register</h1>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('name')" required autofocus placeholder="First Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('name')" required autofocus placeholder="Last Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-select-input class="block mt-1 w-full" id="age" name="age" required>
                <option value="" disabled selected>Age Group</option>
                <option value="13-19">13-19</option>
                <option value="20-29">20-29</option>
                <option value="30-39">30-39</option>
                <option value="40-49">40-49</option>
                <option value="50-59">50-59</option>
                <option value="60-69">60-69</option>
                <option value="others">others</option>

            </x-select-input>
            <x-input-error :messages="$errors->get('age')" class="mt-2" />
        </div>
        


        <!-- Email Address -->
        <div class="mt-4">
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required placeholder="Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-text-input id="number" class="block mt-1 w-full" type="text" name="number" :value="old('number')" required placeholder="+60 12-3739 1590" />
            <x-input-error :messages="$errors->get('number')" class="mt-2" />
        </div>

        <div class="form-group">
    @foreach($options as $option)
        <div class="checkbox-container">
            <input type="checkbox" id="regime_{{ $option->id }}" name="regimes[]" value="{{ $option->id }}">
            <label for="regime_{{ $option->id }}">{{ $option->name }}</label>
        </div>
    @endforeach
</div>


    <div class="checkbox-container">
        <input type="checkbox" id="consent" name="consent" value="1" required>
        <label for="consent">
            I acknowledge and consent to Paragoncorp and/or its agents or affiliates updating me on the latest launches, promotional materials, offers, and gifts via WhatsApp and/or email. I understand that my personal data will be collected and processed in accordance with the event's privacy policy.
        </label>
    </div>

   

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
