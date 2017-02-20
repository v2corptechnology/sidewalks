@extends('spark::layouts.app')

@section('scripts')
    <link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">  
    <link href="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.css" rel="stylesheet" >
    <script src="//rawgit.com/mrdoob/three.js/dev/build/three.min.js"></script>
    <script src="//rawgit.com/malko/D.js/master/lib/D.min.js"></script>
    <script src="//rawgit.com/mistic100/uEvent/master/uevent.min.js"></script>
    <script src="//rawgit.com/olado/doT/master/doT.min.js"></script>
    <script src="//rawgit.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js"></script>
    <script src="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.js"></script>
    <style>
        .schedules__day:not(:last-child) {
            border-bottom: 1px solid #eaeaea;
        }

        /** EXTRA **/
        .form-inline.pull-right {margin-top: -0.6rem;}
    </style>
@endsection

@section('content')
<div class="container" id="root">
    <div class="row">
        <div class="col-sm-3 col-sm-push-9">
            <div class="box">
                <div class="box__content">
                    <h1 class="box__heading">
                        <a class="pull-right" href="{{ route('shops.edit', $shop) }}" 
                           title="Edit shop details">
                           <i class="fa fa-ellipsis-v fa-fw"></i> 
                           <span class="sr-only">Edit shop details</span>
                        </a>
                        {{ $shop->name }}
                    </h1>
                    @if ($shop->schedules->first())
                        <ul class="list-unstyled schedules">
                            @foreach ($shop->schedules->groupBy('day_of_week') as $schedule)
                                <li class="schedules__day">
                                    @if (\Carbon\Carbon::now()->dayOfWeek == $schedule->first()->day_of_week)
                                        <b>
                                    @endif
                                    {{ jddayofweek(($schedule->first()->day_of_week-1), 1) }}

                                    <span class="pull-right">
                                        @foreach ($schedule as $hour)
                                            {{ \Carbon\Carbon::createFromFormat('H:i', $hour->time_open)->format('H:i') }}–{{ \Carbon\Carbon::createFromFormat('H:i', $hour->time_open)->addMinutes($hour->working_time)->format('H:i') }}
                                            @if (! $loop->last) 
                                            , 
                                            @endif
                                        @endforeach
                                    </span>
                                    @if (\Carbon\Carbon::now()->dayOfWeek == $schedule->first()->day_of_week)
                                        </b>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                <img class="img-responsive" src="{{ $shop->addressImage('350x200') }}" srcset="{{ $shop->addressImage('350x200', 2) }} 2x" alt="{{ $shop->address }}">

                <div class="box__content">
                    <p><i class="fa fa-map-marker fa-fw"></i> {{ $shop->address }}</p>
                </div>
            </div>

            @if (auth()->check() && $shop->user_id == auth()->user()->id)
                <a class="btn btn-warning btn-block" href="{{ route('shops.markers.create', $shop) }}">Add markers</a>
            @endif
        </div>
        <div class="col-sm-9 col-sm-pull-3">
            <div class="box">
                <pano panorama="{{ asset('storage/panoramas/' . $shop->panorama) }}" 
                      raw-markers="{{ $shop->markers->toJson() }}">
                </pano>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-9">
                    <shop-items raw-items="{{ $shop->items->load('categories')->toJson() }}"></shop-items>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection