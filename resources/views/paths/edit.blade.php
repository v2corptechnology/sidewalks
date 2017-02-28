@extends('spark::layouts.app')

@section('scripts')
    <style>
        .panorama-list__item {margin-bottom: 1rem;}
    </style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>Path panoramas</h1>
            <ul class="row list-unstyled">
                @foreach ($path->panoramas as $pano)
                    <li class="col-sm-4 panorama-list__item">
                        <a href="{{ route('panoramas.edit', $pano) }}">
                            <img class="img-responsive" 
                                 src="{{ asset('storage/panoramas/' . $pano->image) }}" 
                                 alt="{{ $pano->image }}">
                        </a>
                        <small>
                            <i class="fa fa-map-marker"></i> {{ $pano->GPSLongitude }} -
                            {{ $pano->GPSLatitude }}
                        </small>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-4">
            <h1>Path info</h1>
            <div class="box">
                <div class="box__content">
                    {{ $path->name }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection