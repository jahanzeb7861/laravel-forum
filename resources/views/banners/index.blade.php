@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @include ('banners._list')


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
        </div>
    </div>
@endsection
