<x-app-layout>
    <div class="station-page main main-bg">
        <div class="branding-container mb-3">
            @include('components.branding')
        </div>
    <div id="mainContent" class="col-12 mt-3 text-content text-center">
        
        <div class="content">
          <h1 class="station-number">0{{$station->id}}</h1>
          <h2 class="station-name">{{$station->name}}</h2>
          <p class="tag-line">{{$station->description}}</p>
        </div>
        <div class="station-img">
          <img src="{{ asset('images/station' . $station->id . 'main.png') }}" alt="">

        </div>
        <div class="scanner-button">
          <button id="scan-btn" class="scan-btn">
              <img src="{{ asset('images/camera.png') }}">
          </button>
          <p>Scan the QR Code at the station to proceed</p>
        </div>
      </div>
      <div id="scannerContainer" class="scanner-container d-none">
                <!-- <button id="close" class="camera-btn mx-auto mt-4">x</button> -->
                <div id="reader"></div>
                <div class="mt-3 p-3">
                    <p class="bottom-text px-4 text-center">Find the QR code & Scan to check in the station</p>
                </div>
            </div>
    </div>

    <script>
        const mainContent = document.getElementById('mainContent');
        const scannerContainer = document.getElementById('scannerContainer');

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
    </script>
  </x-app-layout>
