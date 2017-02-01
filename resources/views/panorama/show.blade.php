@extends('spark::layouts.app')

@section('content')
<home :user="user" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        Your application's dashboard.
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>
@endsection


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
        
    <link rel="stylesheet" href="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

    <script src="//rawgit.com/mrdoob/three.js/dev/build/three.min.js"></script>
    <script src="//rawgit.com/malko/D.js/master/lib/D.min.js"></script>
    <script src="//rawgit.com/mistic100/uEvent/master/uevent.min.js"></script>
    <script src="//rawgit.com/olado/doT/master/doT.min.js"></script>
    <script src="//rawgit.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js"></script>
    <script src="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.js"></script>
</head>
<body>

<div class="container">

    <div id="photosphere"></div>

    <hr>

    <p class="text-center">
        <a href="{{ route('panoramas.markers.create', $panorama) }}" class="btn btn-warning">Add marker</a>
    </p>

</div>

<script>
    window.onload = function() {
        var PSV = new PhotoSphereViewer({
            panorama: '{{ asset('storage/' . $panorama->picture) }}',
            container: 'photosphere',
            caption: 'Roots Beverly Hills • 1505 Abbot Kinney Blvd, Venice, CA 90291, USA',
            loading_img: 'http://photo-sphere-viewer.js.org/assets/photosphere-logo.gif',
            navbar: 'zoom caption fullscreen',
            default_fov: 70,
            default_long: 3.618199,
            default_lat:  -0.25,
            mousewheel: false,
            time_anim: false,
            gyroscope: true,
            size: {
                height: 500
            },
            markers: [
                @foreach($panorama->markers as $marker)
                    {
                        id: {{ $marker->id }},
                        longitude: {{ $marker->deg[1] }},
                        latitude: {{ $marker->deg[0] }},
                        image: 'http://photo-sphere-viewer.js.org/assets/pin-red.png',
                        width: 32,
                        height: 32,
                        anchor: 'bottom center',
                        tooltip: 'More info to come',
                    }
                    @if (! $loop->last) , @endif
                @endforeach
            ]
        });
    };
</script>
</body>
</html>