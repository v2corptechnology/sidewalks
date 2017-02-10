@extends('spark::layouts.app')

@section('scripts')
    <style>
        .col-sm-4 {margin-bottom: 1rem;}
        .close {
            position: absolute;
            right: 15px;
            top: 0;
            transform: translateX(50%) translateY(-50%);
        }
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
                placeholder: 'Choose'
            });
        });
    </script>
@endsection

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

                        <select class="form-control js-link_to" name="link_to" required>
                            <optgroup label="Categories">
                                @foreach($shop->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Items">
                                @foreach($shop->items as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                        
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
@endsection