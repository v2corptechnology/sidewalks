@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <path-viewer :view-id="1"></path-viewer>
            </div>
        </div>
    </div>
</div>
@endsection