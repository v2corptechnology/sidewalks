@extends('spark::layouts.app')

@section('scripts')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>
                <a href="{{ route('paths.edit', $panorama->path) }}" title="Back to path panoramas">{{ $panorama->path->name }}</a> 
                <small>/ Panorama {{ $panorama->id }}</small>

                <a class="pull-right h4" href="{{ route('panoramas.show', $panorama) }}" title="View full path">
                    <small><i class="fa fa-refresh"></i> visit</small>
                </a>
            </h1>
            <path-viewer view-id="{{ $panorama->id }}" height="500" editable></path-viewer>
        </div>
        <div class="col-sm-4">
            <h1>Linked views</h1>
            <div class="box">
                <div class="box__content">
                    <path-editor :path-id="{{ $panorama->path->id }}" :panorama-id="{{ $panorama->id }}"></path-editor>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection