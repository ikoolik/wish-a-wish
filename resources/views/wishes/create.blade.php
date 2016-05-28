@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Новое желание</h1>
            <div class="row">
                <div class="col-md-3 hidden-sm hidden-xs">
                    <img src="http://previews.123rf.com/images/naddya/naddya1311/naddya131100064/24188141-Gift-box-Vector-black-silhouette--Stock-Vector-gift.jpg" class="img-thumbnail">
                </div>
                <div class="col-md-7">
                    {{ Form::open(['route' => ['wishes.store']]) }}
                    <div class="form-group">
                        {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Название']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::text('image_url', '', ['class' => 'form-control', 'placeholder' => 'URL картинки']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Комментарий']) }}
                    </div>
                    <hr>
                    {{ Form::button('<i class="fa fa-save"></i> Сохранить', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection
