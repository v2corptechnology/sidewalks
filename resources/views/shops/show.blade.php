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
        .box {
            border-radius: 2px;
            background-color: #ffffff;
            box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.08);
            border: solid 1px #eaeaea;
            margin-bottom: 3rem;
        }

        .box__content {
            padding: 2rem;
        }

        .box__content:last-child :last-child {
            margin-bottom: 0;
        }

        .box__heading {
            font-family: 'Open Sans', sans-serif;
            font-size: 18px;
            font-weight: 600;
            font-style: normal;
            font-stretch: normal;
            line-height: 1.17;
            letter-spacing: normal;
            color: #454545;
            margin: 0 0 1.5rem 0;
            padding: 0;
        }

        .schedules {

        }
        .schedules__day:not(:last-child) {
            border-bottom: 1px solid #eaeaea;
        }

        .item__content {
            display: block;
            position: relative;
        }

        .item__title {
            background: linear-gradient(transparent 0%, rgba(0, 0, 0, 0.65) 100%);
            bottom: 0;
            color: #FFF;
            display: block;
            left: 0;
            font-weight: bold;
            overflow: hidden;
            padding: 0.5rem;
            position: absolute;
            text-overflow: ellipsis;
            white-space: nowrap;
            width: 100%;
            z-index: 3;
        }

        .item:hover .item__title, 
        .item:focus .item__title {
            background: linear-gradient(transparent 0%, rgba(0, 0, 0, 0.65) 60%);
            white-space: inherit;
        }

        .item__price {
            background-color: #FF3D7B;
            border-radius: 2px;
            padding: 0.25rem 0.5rem;
        }

        /** EXTRA **/
        .h3 {border-bottom: 1px solid #eaeaea;}
        .form-inline.pull-right {margin-top: 1.6rem;}
    </style>
@endsection

@section('content')
<div class="container" id="root">
    <div class="row">
        <div class="col-sm-3 col-sm-push-9">
            <div class="box">
                <div class="box__content">
                    <h1 class="box__heading">{{ $shop->name }}</h1>
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
        </div>
        <div class="col-sm-9 col-sm-pull-3">
            <div class="box">
                <pano panorama="{{ asset('storage/panoramas/' . $shop->panorama) }}" 
                      markers="{{ $shop->markers->toPSV() }}">
                </pano>
            </div>
        </div>

        <div class="col-sm-12">
            <form action="#" class="form-inline pull-right">
                <label class="control-label" for="filter">
                    <input class="form-control input-sm" type="search" name="filter" id="filter" placeholder="Filter...">
                </label>
            </form>
            <h1 class="h3">{{ $shop->items->count() }} items</h1>
            <div class="row" id="root">
                @each('items.card', $shop->items, 'item')
            </div>
        </div>

    </div>
</div>
@endsection