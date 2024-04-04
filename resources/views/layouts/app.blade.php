<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/0.11.1/trix.css">

     <!-- Font Awesome -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Scripts -->
    <script>
        window.App = {!! json_encode([
            'csrfToken' => csrf_token(),
            'user' => Auth::user(),
            'signedIn' => Auth::check()
        ]) !!};
    </script>

    <style>
        body { padding-bottom: 100px; }
        .level { display: flex; align-items: center; }
        .level-item { margin-right: 1em; }
        .flex { flex: 1; }
        .mr-1 { margin-right: 1em; }
        .ml-a { margin-left: auto; }
        [v-cloak] { display: none; }
        .ais-highlight > em { background: yellow; font-style: normal; }
    </style>

    @yield('head')
</head>
<body>
<div id="app">
    @include ('layouts.nav')

    @php
        use Illuminate\Support\Str;
    @endphp

    @if(!Str::startsWith(request()->path(), 'banners') && !Str::startsWith(request()->path(), 'login'))
        @if(!Str::startsWith(request()->path(), 'profiles'))
            @if(!Str::startsWith(request()->path(), 'register'))
                <div class="container">
                    <div class="row">
                        @if(count($banners) > 0)
                            @foreach($banners as $banner)
                            <div class="form-media-box media-{{ $banner->id }}">
                                        <!-- <img src="{{ asset('uploads/content/' . $banner->image) }}"/> -->
                                        <img src="{{ $banner->link }}" width="900"/>
                                    </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @endif



    @yield('content')


    @if(!Str::startsWith(request()->path(), 'banners') && !Str::startsWith(request()->path(), 'login'))
        @if(!Str::startsWith(request()->path(), 'profiles'))
            @if(!Str::startsWith(request()->path(), 'register'))
                <div class="container">
                    <div class="row">
                        @if(count($banners) > 0)
                            @foreach($banners as $banner)
                                <div class="form-media-box media-{{ $banner->id }}">
                                        <!-- <img src="{{ asset('uploads/content/' . $banner->image) }}"/> -->
                                        <img src="{{ $banner->link }}" width="900"/>
                                    </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif
        @endif
    @endif

    <flash message="{{ session('flash') }}"></flash>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>
</html>
