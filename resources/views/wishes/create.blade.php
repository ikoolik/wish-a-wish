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
                        <label>Название</label>
                        {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Феррари']) }}
                    </div>
                    <div class="form-group">
                        <label>Ссылка на картинку</label>
                        {{ Form::text('image_url', '', ['class' => 'form-control', 'placeholder' => 'http://example.com/image.jpg']) }}
                    </div>
                    <div class="form-group">
                        <label>Комментарий</label>
                        {{ Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Обязательно красного цвета']) }}
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
