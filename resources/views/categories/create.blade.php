@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create category
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" action="{{ route('categories.store') }}" method="post">

                        {!! csrf_field() !!}

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Clothing" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-primary" type="submit">Create</button>
                                <a class="btn btn-link" href="{{ route('categories.index') }}">cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection