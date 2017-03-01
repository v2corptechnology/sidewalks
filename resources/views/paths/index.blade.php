@extends('spark::layouts.app')

@section('scripts')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>Your paths</h1>
            <paths :paths="{{ $paths->toJson() }}"></paths>
        </div>
        <div class="col-sm-4">
            <h1>Create path</h1>
            <div class="box">
                <div class="box__content">
                    <paths-creator :user="user"></paths-creator>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection