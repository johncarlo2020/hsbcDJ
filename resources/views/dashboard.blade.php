<x-app-layout>
  <div class="dashboard main main-bg">
    <div class="branding-container">
        @include('components.branding')
    </div>
    <div class="content">
        <a href="{{ route('station.show', ['id' => 1]) }}">
            <div class="tile">
                <div class="image">
                    <img src="{{ asset('images/station1.png') }}" alt="">
                </div>
                <div class="station">
                    <p class="station-number">02</p>
                    <p class="station-name">SKINVENTURE
                    </p>
                </div>
            </div>
        </a>
        <a href="">
            <div class="tile reverse">
                <div class="image">
                    <img src="{{ asset('images/station1.png') }}" alt="">
                </div>
                <div class="station">
                    <p class="station-number">02</p>
                    <p class="station-name">SKINVENTURE
                    </p>
                </div>
            </div>
        </a>
    </div>
  </div>
</x-app-layout>
