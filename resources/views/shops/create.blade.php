@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create my shop</div>

                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('shops.store') }}" method="post" enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Shop's name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Wonderful shop" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <panorama :user="user" inline-template>
                                <div>
                                    <label class="control-label col-sm-2" for="image">360° picture</label>
                                    <div class="col-sm-10">
                                        <p v-show="image"><img class="img-responsive" :src="image" /></p>
                                        <input class="form-control" type="file" id="image" name="image" required 
                                               v-show="!image" @change="onFileChange">
                                         <div class="text-center" v-show="image">
                                            <button class="btn btn-default" @click="removeImage">Choose another panorama</button>
                                        </div>
                                    </div>
                                </div>
                            </panorama>
                        </div>
                        <div class="form-group">
                            <label for="schedule" class="control-label col-sm-2">Hours</label>
                            <div class="col-sm-10">
                                <schedules></schedules>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
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