@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    My categories
                    <a class="btn btn-sm btn-primary pull-right" href="{{ route('categories.create') }}">Add</a>
                </div>

                <div class="panel-body">
                    <ul>
                        @foreach ($categories as $category)
                            <li>
                                {{ $category->name }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection