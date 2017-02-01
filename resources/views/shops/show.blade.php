@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $shop->name }}</div>

                <div class="panel-body">
                    <ul class="list-unstyled opening-hours">
                        @foreach ($shop->schedules->groupBy('day_of_week') as $schedule)
                            <li>
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
                    <br><br>
                    <pano-viewer panorama="{{ asset('storage/panoramas/' . $shop->panorama) }}" 
                                 markers="{{ $shop->markers->toPSV() }}"
                                 items="{{ $shop->items->toJson() }}"
                                 target-url="{{ route('shops.markers.store', $shop) }}"></pano-viewer>
                    
                    <br><br>
                    @foreach ($shop->items->chunk(3) as $items)
                        <div class="row">
                             @foreach ($items as $item)
                                 <div class="col-sm-4">
                                    <div class="thumbnail">
                                        <a href="{{ route('items.show', $item) }}">
                                            <img class="img-responsive" src="{{ asset("storage/items/originals/{$item->id}/{$item->images[0]}") }}" alt="{{ $item->title }}">
                                            <div class="caption">
                                                <h4>{{ $item->title }}</h4>
                                                <p>{{ $item->description }}</p>
                                            </div>
                                        </a>    
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>  


        
<link rel="stylesheet" href="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.css">

<script src="//rawgit.com/mrdoob/three.js/dev/build/three.min.js"></script>
<script src="//rawgit.com/malko/D.js/master/lib/D.min.js"></script>
<script src="//rawgit.com/mistic100/uEvent/master/uevent.min.js"></script>
<script src="//rawgit.com/olado/doT/master/doT.min.js"></script>
<script src="//rawgit.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js"></script>
<script src="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.js"></script>
@endsection