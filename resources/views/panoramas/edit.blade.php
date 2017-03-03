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

            <panorama image="{{ $panorama->imageUrl }}" 
                      :markers="{{ $panorama->markers->load('markable')->toJson() }}"
                      caption="{{ $panorama->caption }}" editable></panorama>
        </div>
        <div class="col-sm-4">
            <h1>Linked views</h1>
            <div class="box">
                <div class="box__content">
                    <panoramas-creator :path="{{ $panorama->path->toJson() }}" 
                                       :panorama="{{ $panorama->toJson() }}"
                                       :markers="{{ $panorama->markers->load('markable')->toJson() }}"></panoramas-creator>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection