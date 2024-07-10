<x-app-layout>
    <div class="station-page main main-bg">
      <div class="branding-container">
          @include('components.branding')
      </div>
      <div class="content">
        <h1 class="station-number">01</h1>
        <h2 class="station-name">SKINVENTURE</h2>
        <p class="tag-line">Discover the underlying factors contributing to your skin concerns through interactive skin journey.</p>
      </div>
      <div class="station-img">
        <img src="{{ asset('images/station1main.png') }}">
      </div>
      <div class="scanner-button">
        <button class="scan-btn">
            <img src="{{ asset('images/camera.png') }}">
        </button>
        <p>Scan the QR Code at the station to proceed</p>
      </div>
    </div>
  </x-app-layout>
