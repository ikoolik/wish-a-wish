@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ $wish->image_url }}" class="img-thumbnail">
                    </div>
                    <div class="col-md-7">
                        {{ Form::model($wish, ['method' => 'PUT', 'route' => ['wishes.update', $wish->id]]) }}
                        <h1>
                            {{ Form::text('name') }}
                            <small>
                                {{ Form::text('image_url') }}
                            </small>
                        </h1>
                        <div>
                            {{ Form::textarea('description') }}
                        </div>
                        <hr>
                        {{ Form::button('<i class="fa fa-save"></i> Сохранить', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                        {{ Form::close() }}
                    </div>
                    <div class="col-md-2">
                        {{ Form::open(['method' => 'DELETE', 'route' => ['wishes.destroy', $wish->id], 'class' => 'form-inline']) }}
                        {{ Form::button('<i class="fa fa-trash"></i> Удалить', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
