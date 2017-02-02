@extends('spark::layouts.app')

@section('content')
<div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $item->title }}</div>

                    <div class="panel-body">
                        <p>{{ $item->description }}</p>
                        <h5>Categories</h5>
                        <ul>
                            @foreach ($item->categories as $category)
                                <li><a href="{{ route('categories.show', $category) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                        <h5>Info</h5>
                        <span><span class="label label-warning">price: {{ $item->amount }} {{ $item->symbol }}</span></span><br>
                        <span><span class="label label-info">quantity: {{ $item->quantity }}</span></span>
                        <div class="row">
                            @foreach ($item->images as $image)
                                <div class="col-sm-6">
                                    <img class="img-responsive" src="{{ asset("storage/items/originals/{$item->id}/{$image}") }}" alt="{{ $item->title }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection