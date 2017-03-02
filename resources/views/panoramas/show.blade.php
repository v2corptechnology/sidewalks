@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <panorama image="{{ $panorama->imageUrl }}" 
                          :markers="{{ $panorama->markers->load('markable')->toJson() }}"
                          caption="Long: {{ $panorama->GPSLongitude . ", Lat: " . $panorama->GPSLatitude}}"></panorama>
            </div>
        </div>
    </div>
</div>
@endsection