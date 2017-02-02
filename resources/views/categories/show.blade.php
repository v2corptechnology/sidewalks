@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $category->name }}</div>

                <div class="panel-body">
                	<div class="row">
						@foreach ($category->items as $item)
							 <div class="col-sm-4">
							    @include('items.card', ['item' => $item])
							</div>
						@endforeach
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection