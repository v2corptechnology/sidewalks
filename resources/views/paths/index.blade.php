@extends('spark::layouts.app')

@section('scripts')
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-8">
            <h1>Your paths</h1>
            <ul class="row list-unstyled">
                @foreach ($paths as $path)
                    <li class="col-sm-4">
                        <a href="{{ route('paths.edit', $path) }}">
                            @if ($path->panoramas()->first())
                                <img class="img-responsive" src="{{ asset('panoramas/' . $path->panoramas()->first()->image) }}" alt="">
                            @else
                                No panorama image
                            @endif
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-4">
            <h1>Create path</h1>
            <paths :user="user"></paths>
        </div>
    </div>
</div>
@endsection