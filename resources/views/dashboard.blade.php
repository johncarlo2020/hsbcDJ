<x-app-layout>
  <div class="dashboard main main-bg">
    <div class="branding-container">
        @include('components.branding')
    </div>
    <div class="content">
        @foreach ($stations  as $station)
        <a href="{{ route('station.show', ['station' => $station->id]) }}">
            <div class="tile {{ $station->id %2 == 0? '':'reverse' }}">
                <div class="image">
                  <img src="{{ asset('images/station' . $station->id . '.png') }}" alt="">
                    <div class="check-mark {{ $station->status == false ? 'd-none':'' }}">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
                <div class="station">
                    <p class="station-number">{{$station->id}}</p>
                    <p class="station-name">{{$station->name}}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
  </div>
</x-app-layout>
