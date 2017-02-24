@extends('spark::layouts.app')

@section('scripts')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h1>Your paths</h1>
        <paths :user="user"></paths>
    </div>
</div>
@endsection