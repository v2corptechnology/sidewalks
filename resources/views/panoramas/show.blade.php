@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <path-viewer :view-id="{{ $panorama->id }}" fullscreen caption="{{ $panorama->GPSLongitude . ', ' . $panorama->GPSLatitude }}"></path-viewer>
            </div>
        </div>
    </div>
</div>
@endsection