@extends('spark::layouts.app')

@section('scripts')
    <style>
        .h3 {border-bottom: 1px solid #eaeaea;}
    </style>
    <link href="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.6/select2-bootstrap.min.css" rel="stylesheet">
    <script src="//code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="//rawgit.com/mrdoob/three.js/dev/build/three.min.js"></script>
    <script src="//rawgit.com/malko/D.js/master/lib/D.min.js"></script>
    <script src="//rawgit.com/mistic100/uEvent/master/uevent.min.js"></script>
    <script src="//rawgit.com/olado/doT/master/doT.min.js"></script>
    <script src="//rawgit.com/mrdoob/three.js/master/examples/js/controls/DeviceOrientationControls.js"></script>
    <script src="//rawgit.com/mistic100/Photo-Sphere-Viewer/master/dist/photo-sphere-viewer.min.js"></script>
    <script>
        $(function(){
            $('.js-link_to').select2({
                placeholder: 'Select item or category'
            }).on('select2:select', function (event) {
                Bus.$emit('maker-associated');
            });
        });
    </script>
@endsection

@section('content')
<item :user="user" inline-template>
    <div class="container">
        <div class="col-sm-3 col-sm-push-9">
            <div class="box">
                <div class="box__content">
                    <h1 class="box__heading">{{ $shop->name }}</h1>
                        
                    <p class="help-block">Move the panorama and click on it once you have located the item.</p>

                    <attach-marker raw-categories="{{ $shop->categories->toJson() }}" 
                                   raw-items="{{ $shop->items->toJson() }}">
                    </attach-marker>
                </div>
            </div>
            <a href="{{ route('shops.show', $shop) }}" class="btn btn-block btn-warning">I'm done</a>
        </div>
        <div class="col-sm-9 col-sm-pull-3">
            <div class="box">
                <pano panorama="{{ asset('storage/panoramas/' . $shop->panorama) }}" 
                      editable="true"
                      raw-markers="{{ $shop->markers->toJson() }}"></pano>
            </div>
        </div>
    </div>
</item>
@endsection