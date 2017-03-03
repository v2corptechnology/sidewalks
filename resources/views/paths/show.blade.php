@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <panorama image="{{ $path->panoramas()->first()->imageUrl }}" 
                          :markers="{{ $path->panoramas()->first()->load('markers.markable')->markers->toJson() }}"
                          caption="{{ $path->panoramas()->first()->caption }}"></panorama>
            </div>
        </div>
    </div>
</div>
@endsection