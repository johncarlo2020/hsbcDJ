<x-app-layout>
    <div class="modal fade" id="scanCompleteModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="content text-center">
                    <div class="image-check">
                        <i class="fa-regular check"></i>
                        </div>
                        <div class="text-content">
                            <p class="station-text">Station <span class="station_id"></span></p>
                            <p class="message">
                                    Check-in Successful
                            </p>
                        </div>
                        <div class="button">
                            <a href="{{ route('dashboard') }}" class="btn-okay btn text-light">
                                Close
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="station-page main main-bg">
        <div class="branding-container mb-3">
            @include('components.branding')
        </div>
    <div id="mainContent" class=" text-content text-center">
        
        <div class="content">
          <h1 class="station-number">0{{$station->id}}</h1>
          <h2 class="station-name">{{$station->name}}</h2>
          <p class="tag-line">{{$station->description}}</p>
        </div>
        <div class="station-img">
          <img src="{{ asset('images/station' . $station->id . 'main.jpg') }}" alt="">

        </div>
        @if( $user == false )
        <div class="scanner-button">
          <button id="scan-btn" class="scan-btn">
              <img src="{{ asset('images/camera.png') }}">
          </button>
          <p>Scan the QR Code at the station to proceed</p>
        </div>
        @endif
      </div>
      <div id="scannerContainer" class="scanner-container d-none">
                <!-- <button id="close" class="camera-btn mx-auto mt-4">x</button> -->
                <div id="reader"></div>
                <div class="mt-3 p-3">
                    <p class="bottom-text px-4 text-center">Find the QR code & Scan to check in the station</p>
                </div>

                <div class="button" id="btn-back">Back</div>
            </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        
        const mainContent = document.getElementById('mainContent');
        const scannerContainer = document.getElementById('scannerContainer');
        document.getElementById('btn-back').addEventListener('click', function(event) {
            event.preventDefault();
            mainContent.classList.remove('d-none');
            scannerContainer.classList.add('d-none');
        });

      document.getElementById('scan-btn').addEventListener('click', function(event) {
            event.preventDefault();

            mainContent.classList.add('d-none');
            scannerContainer.classList.remove('d-none');
            const isLandscape = window.innerWidth > window.innerHeight;
            //get permission to use camera dont start qr scanner until permission is granted

            const html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start({
            facingMode: "environment",
        }, {
            fps: 10,
            qrbox: { width: 200, height: 250 },
            aspectRatio: isLandscape ? 3 / 4 : 4 / 3

        },
                    qrCodeMessage => {
                        console.log(`${qrCodeMessage}`);
                         sendMessage(`${qrCodeMessage}`);
                        html5QrCode.stop();

                    },
                    errorMessage => {
                        console.log(`QR Code no longer in front of camera.`);
                    })
                .catch(err => {
                    console.log(`Unable to start scanning, error: ${err}`);
                });

        });
        function sendMessage(message) {
            // Fetch the CSRF token from the meta tag
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            console.log(message);

            $.ajax({
                url: '{{ route('process_qr_code') }}', // Using Laravel's route() helper function
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken, // Include the CSRF token in the headers
                },
                data: {
                    qrCodeMessage: message,
                    station: {{ $station->id }}
                },
                success: function(response) {
                    console.log('QR Code message sent successfully:', response);
                    // Handle success response if needed
              
                    const trimmedMessage = message.trim();
                    // Get the last character of the QR code message
                    const lastCharacter = trimmedMessage.charAt(trimmedMessage.length - 1);
                    $('.station_id').html(lastCharacter);

                    
                    $('.check').addClass('fa-circle-check text-success');

                    $('#scanCompleteModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error sending QR Code message:', error);
                    $('.station-text').html('Failed');
                    $('.message').html('Invalid QR code. Please try again.');
                    $('.check').addClass('fa-circle-xmark text-danger');

                    $('#scanCompleteModal').modal('show');


                }
            });
        }
    </script>
  </x-app-layout>
