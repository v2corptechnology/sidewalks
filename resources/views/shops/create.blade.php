@extends('spark::layouts.app')

@section('scripts')
    <style>
        h1.text-center {margin-top: 0;}
    </style>
@endsection

@section('content')
<div class="container">
    <h1 class="h3 text-center">Create my shop</h1>
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                <div class="box__content">
                    <form class="form-horizontal" action="{{ route('shops.store') }}" method="post" enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="name">Shop name</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name" placeholder="Wonderful shop" required>
                                {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="phone">Shop phone</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="phone" value="{{ old('phone') }}" id="phone" type="tel" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" placeholder="+1 665-555-1" required>
                                {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="email">Shop email</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="email" value="{{ old('email') }}" id="email" type="email" placeholder="wonderful@shop.com" required>
                                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="address">Shop address</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="address" value="{{ old('address') }}" id="address" type="text" placeholder="1 Quality Street, 99110 Ca" required>
                                {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group {{ $errors->has('contact') ? ' has-error' : '' }}">
                            <label class="control-label col-sm-4" for="contact">Contact name</label>
                            <div class="col-sm-4">
                                <input class="form-control" name="contact" value="{{ old('contact', auth()->user()->name) }}" id="contact" type="text" placeholder="Mister Owner" required>
                                {!! $errors->first('contact', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-4">
                                <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
@endsection