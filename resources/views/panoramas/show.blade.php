@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <panorama image="{{ $panorama->imageUrl }}" 
                          :markers="{{ $panorama->markers->load('markable')->toJson() }}"
                          caption="{{ $panorama->caption }}"></panorama>

                <div id="cards" class="hidden">
                    @foreach (\App\Item::where('path_id', $panorama->path->id)->get() as $item)
                        @include('items.card', ['item' => $item, 'showDescription' => true])
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection