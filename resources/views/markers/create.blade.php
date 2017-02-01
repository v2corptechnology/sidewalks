@extends('spark::layouts.app')

@section('content')
<item :user="user" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create markers
                    </div>

                    <div class="panel-body">
                        
                        <p class="help-block">Move the panorama and click on it once you have located the item.</p>

                        <pano-viewer panorama="{{ asset('storage/panoramas/' . $shop->panorama) }}" 
                                     markers="{{ $shop->markers->toPSV() }}"
                                     items="{{ $shop->items->toJson() }}"
                                     target-url="{{ route('shops.markers.store', $shop) }}"></pano-viewer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</item>


        
<link rel="stylesheet" href="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.css">

<script src="//rawgit.com/mrdoob/three.js/dev/build/three.min.js"></script>
<script src="//rawgit.com/malko/D.js/master/lib/D.min.js"></script>
<script src="//rawgit.com/mistic100/uEvent/master/uevent.min.js"></script>
<script src="//rawgit.com/olado/doT/master/doT.min.js"></script>
<script src="//rawgit.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js"></script>
<script src="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.js"></script>
@endsection