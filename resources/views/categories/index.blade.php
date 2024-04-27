@extends('layouts.app')

@section('content')


    <div class="contsaainer" style="margin-top: 2rem;">
        <div class="row">

            <div class="col-md-2" style="margin-top: 2rem;margin-bottom: 2rem;">

                @if(!(auth()->user() && auth()->user()->isAdmin()))
                    @if(!Str::startsWith(request()->path(), 'banners') && !Str::startsWith(request()->path(), 'login'))
                        @if(!Str::startsWith(request()->path(), 'profiles'))
                            @if(!Str::startsWith(request()->path(), 'register'))
                                <div class="contasiner">
                                    <div class="row">
                                        @if(count($banners) > 0)
                                            @foreach($banners as $banner)
                                                @if($banner->position == 'left')
                                                    <div class="form-media-box media-{{ $banner->id }}">
                                                            <!-- <img src="{{ asset('uploads/content/' . $banner->image) }}" width="{{ $banner->size }}" style="position: sticky;left: 0;z-index: 1111111;"/> -->
                                                            <a href="{{ $banner->store_link }}" target="_blank">
                                                            <img src="{{ $banner->link }}" width="{{ $banner->size }}" style="position: sticky;left: 0;z-index: 1111111;"/>
                                                            </a>
                                                        </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endif
            </div>



            <div class="col-md-7">
                @include ('categories._list')
            </div>

            <!-- <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Search
                    </div>

                    <div class="panel-body">
                        <form method="GET" action="/threads/search">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." name="q" class="form-control">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div> -->


            <div class="col-md-2">
                @if(!(auth()->user() && auth()->user()->isAdmin()))
                    @if(!Str::startsWith(request()->path(), 'banners') && !Str::startsWith(request()->path(), 'login'))
                        @if(!Str::startsWith(request()->path(), 'profiles'))
                            @if(!Str::startsWith(request()->path(), 'register'))
                                <div class="contasiner">
                                    <div class="row">
                                        @if(count($banners) > 0)
                                            @foreach($banners as $banner)
                                                @if($banner->position == 'right')
                                                    <div class="form-media-box media-{{ $banner->id }}">
                                                        <!-- <img src="{{ asset('uploads/content/' . $banner->image) }}" width="{{ $banner->size }}" style="position: sticky;left: 0;z-index: 1111111;"/> -->
                                                        <a href="{{ $banner->store_link }}" target="_blank">
                                                            <img src="{{ $banner->link }}" width="{{ $banner->size }}" style="position: sticky;left: 0;z-index: 1111111;"/>
                                                            </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endif
                    @endif
                @endif
            </div>


        </div>
    </div>
@endsection
