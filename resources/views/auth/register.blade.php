<x-guest-layout>
    <div class="register">
        <h1>Register</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-text-input id="fname" class="block w-full mt-1" type="text" name="fname" :value="old('name')"
                    required autofocus placeholder="First Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-text-input id="lname" class="block w-full mt-1" type="text" name="lname" :value="old('name')"
                    required autofocus placeholder="Last Name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-select-input class="block w-full mt-1" id="age" name="age" required>
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
            <div class="">
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required placeholder="Email Address" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="">
                <x-text-input id="number" class="block w-full mt-1" type="number" name="number" :value="old('number')"
                    required placeholder="" />
                <x-input-error :messages="$errors->get('number')" class="mt-2" />
            </div>
            <div>
                <span id="valid-msg" class="d-none text-danger"></span>
                <span id="error-msg" class="d-none text-danger"></span>
            </div>

            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                            Skin Regime
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            @foreach($options as $option)
                            <div class="checkbox-container">
                                <input type="checkbox" id="regime_{{ $option->id }}" name="regimes[]"
                                    value="{{ $option->id }}">
                                <label for="regime_{{ $option->id }}"></label>
                                <p>{{ $option->name }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="checkbox-container concent-container first">
                <input type="checkbox" id="consent2" name="consent" value="1" required>
                <label for="consent2">
                </label>
                <p>I have read and agree to the Terms and Conditions and <a href="https://wardahbeauty.com/privacy-policy">privacy policy.</a></p>
            </div>

            <div class="checkbox-container concent-container">
                <input type="checkbox" id="marketing" name="marketing" value="0"  >
                <label for="marketing">
                </label>
                <p>I agree to receive marketing and promotional communications from Wardah via e-mail and text messages (including SMS/WhatsApp).</p>
            </div>



            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="button" id="submitButton">
                    {{ __('SUBMIT') }}
                </x-primary-button>
            </div>
        </form>

        <div class="bottom-text">
            <p>Already Register Please log in<a class="" href="{{ route('login') }}">
                    {{ __('here') }}
                </a></p>
        </div>
    </div>
</x-guest-layout>

<script>

 document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector("#form");
   const input = document.querySelector("#number");

   const errorMsg = document.querySelector("#error-msg");
    const validMsg = document.querySelector("#valid-msg");

// here, the index maps to the error code returned from getValidationError - see readme
    const errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    const submitButton = document.querySelector('#submitButton')
    const iti = window.intlTelInput(input, {
    initialCountry: "my",
    hiddenInput: "country",
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", // just for formatting/placeholders etc
    });

    const reset = () => {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("d-none");
        validMsg.classList.add("d-none");
        };

    const showError = (msg) => {
        input.classList.add("error");
        errorMsg.innerHTML = msg;
        errorMsg.classList.remove("d-none");
        };

        input.addEventListener('keyup', function() {
        reset();
        if (!input.value.trim()) {
            showError("Required");
            submitButton.disabled = true;
        } else if (iti.isValidNumber()) {
            validMsg.classList.remove("d-none");
            submitButton.disabled = false;
        } else {
            const errorCode = iti.getValidationError();
            const msg = errorMap[errorCode] || "Invalid number";
            showError(msg);
            submitButton.disabled = true;
        }
    });




    const checkboxes = document.querySelectorAll("input[type=checkbox][name='regimes[]'");
    const lastCheckboxContainer = document.querySelector('input[type=checkbox][name="regimes[]"][value="7"]').closest('.checkbox-container');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const enabledSettings = Array.from(checkboxes).filter(i => i.checked).map(i => i.value);

            // Toggle visibility of the last checkbox
            lastCheckboxContainer.style.display = enabledSettings.includes('7') || enabledSettings.length === 0 ? 'flex' : 'none';

            // Disable or enable other checkboxes
            checkboxes.forEach(function(cb) {
                cb.disabled = enabledSettings.includes('7') && cb.value !== '7';
            });
        });
    });
});
</script>
