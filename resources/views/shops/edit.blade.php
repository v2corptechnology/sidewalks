@extends('spark::layouts.app')

@section('content')
<div class="container">
    <h1 class="h3 text-center">{{ $shop->name }}</h1>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box__content">
                    <form class="form-horizontal" action="{{ route('shops.update', $shop) }}" method="post" enctype="multipart/form-data">

                        {!! method_field('patch') !!}
                        {!! csrf_field() !!}

                        @if (! request()->exists('narrow'))

                            <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-4" for="phone">Shop phone</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="phone" value="{{ old('phone', $shop->phone) }}" id="phone" type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" placeholder="+1 665-555-1" required>
                                    {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-4" for="email">Shop email</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="email" value="{{ old('email', $shop->email) }}" id="email" type="email" placeholder="wonderful@shop.com" required>
                                    {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-4" for="address">Shop address</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="address" value="{{ old('address', $shop->address) }}" id="address" type="text" placeholder="1 Quality Street, 99110 Ca" required>
                                    {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>
                            <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                                <label class="control-label col-sm-4" for="contact">Contact name</label>
                                <div class="col-sm-4">
                                    <input class="form-control" name="contact" value="{{ old('contact', $shop->contact) }}" id="contact" type="text" placeholder="Mister Owner" required>
                                    {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
                                </div>
                            </div>

                        @endif

                        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                            <panorama-chooser :user="user" inline-template>
                                <div>
                                    <label class="control-label col-sm-4" for="image">360° picture</label>
                                    <div class="col-sm-4">
                                        <p v-show="image"><img class="img-responsive" :src="image" /></p>
                                        <div class="form-control" v-show="!image">
                                            <input type="file" id="image" name="image" required @change="onFileChange">
                                        </div>
                                         <div v-show="image">
                                            <a href="#" @click="removeImage">Choose another panorama</a>
                                        </div>
                                        {!! $errors->first('image', '<p class="help-block">:message</p>') !!}
                                    </div>
                                </div>
                            </panorama-chooser>
                        </div>
                        <div class="form-group {{ $errors->has('schedules') ? ' has-error' : '' }}">
                            <label for="schedule" class="control-label col-sm-4">Hours</label>
                            <div class="col-sm-8">
                                <p class="help-block">
                                    You can't edit your hours right now.
                                </p>
                                {{--<schedules></schedules>--}}
                                {!! $errors->first('schedules', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>                    
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection