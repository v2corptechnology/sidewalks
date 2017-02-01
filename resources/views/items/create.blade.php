@extends('spark::layouts.app')

@section('content')
<style>
    .col-sm-4 {margin-bottom: 1rem;}
    .close {
        position: absolute;
        right: 15px;
        top: 0;
        transform: translateX(50%) translateY(-50%);
    }
</style>
<item inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">
                        <div class="btn-group btn-group-sm">
                            <label :class="[selectedTab == 'import' ? 'active' : '', 'btn btn-default']">
                                <input class="sr-only" type="radio" name="method" autocomplete="off" :checked="selectedTab == 'import'" @click="selectedTab = 'import'"> Search Import <b>+</b>
                            </label>
                            <label :class="[selectedTab == 'manual' ? 'active' : '', 'btn btn-default']">
                                <input class="sr-only" type="radio" name="method" autocomplete="off" :checked="selectedTab == 'manual'" @click="selectedTab = 'manual'"> Manually
                            </label>
                        </div>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}

                            @if (count($errors) > 0)
                                <hr>
                                <ul class="list-group">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <hr>
                            @endif
                            
                            <fieldset class="form-group" v-show="selectedTab == 'import'">
                                <scraper @scraped="onItemScraped"></scraper>
                            </fieldset>

                            <div class="row" v-show="selectedTab == 'manual'">
                                <div class="col-sm-6">
                                    <fieldset>
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label class="control-label" for="title">
                                                Title
                                            </label>
                                            <input class="form-control" type="text" name="title" id="title"
                                                   placeholder="Title of your item" minlength="3" pattern=".{3,}" required 
                                                   v-model="item.title">
                                            {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group {{ $errors->has('amount') ? ' has-error' : '' }}">
                                                    <label class="control-label" for="amount">
                                                        Price
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-addon">$</span>
                                                        <input class="form-control" type="number" name="amount" id="amount" min="1" step="0.01"
                                                               placeholder="Price in dollars" pattern="\d+(,\d{2})?" required 
                                                               v-model="item.amount">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="quantity" class="control-label">Quantity</label>
                                                    <input class="form-control" name="quantity" type="number" min="1"
                                                           v-model="item.quantity">
                                                    {!! $errors->first('quantity', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                            <label class="control-label" for="description">
                                                Description
                                            </label>
                                            <textarea class="form-control" placeholder="Describe your item" name="description" 
                                                      id="description" cols="30" rows="5" required
                                                      v-model="item.description"></textarea>
                                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-sm-6">
                                    <fieldset>
                                        <label for="image">Images</label>
                                        <div class="form-group" v-show="item.images.length">
                                            <div class="row">
                                                <div class="col-sm-4" v-for="(image, index) in item.images">
                                                    <button type="button" class="close" aria-label="Close" @click="item.images.splice(index, 1)">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <img class="img-responsive" :src="image">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="image" id="image" accept="image/*" multiple :required="! item.images.length"
                                                   @change="onFileChange">
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            
                            <fieldset class="text-center" v-show="selectedTab == 'manual'">
                                <input type="hidden" name="images[]" v-for="image in item.images" :value="image">
                                <input type="hidden" name="symbol" value="$">
                                <input type="hidden" name="extra[url]" v-model="scrapedUrl">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <input type="hidden" name="shop_id" value="{{ auth()->user()->shop->id }}">
                                <button class="btn btn-default" type="submit" name="next" value="save">Save</button>
                                <button class="btn btn-primary" type="submit" name="next" value="add">Save + add another</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</item>
@endsection