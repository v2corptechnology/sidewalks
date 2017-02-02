@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $category->name }}</div>

                <div class="panel-body">
                	<ul>
                        @foreach ($category->items as $item)
                            <li><a href="{{ route('items.show', $item) }}">{{ $item->title }}</a></li>
                        @endforeach                		
                	</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection