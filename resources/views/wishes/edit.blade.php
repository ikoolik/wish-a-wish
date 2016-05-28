@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Изменить желание</h1>
            <div class="row">
                <div class="col-md-3 hidden-sm hidden-xs">
                    <img src="{{ $wish->image_url }}" class="img-thumbnail">
                </div>
                <div class="col-md-7">
                    {{ Form::model($wish, ['method' => 'PUT', 'route' => ['wishes.update', $wish->id]]) }}
                    {{ Form::open(['route' => ['wishes.store']]) }}
                    <div class="form-group">
                        <label>Название</label>
                        {{ Form::text('name', $wish->name, ['class' => 'form-control', 'placeholder' => 'Феррари']) }}
                    </div>
                    <div class="form-group">
                        <label>Ссылка на картинку</label>
                        {{ Form::text('image_url', $wish->image_url, ['class' => 'form-control', 'placeholder' => 'http://example.com/image.jpg']) }}
                    </div>
                    <div class="form-group">
                        <label>Комментарий</label>
                        {{ Form::textarea('description', $wish->description, ['class' => 'form-control', 'placeholder' => 'Обязательно красного цвета']) }}
                    </div>
                    <hr>
                    {{ Form::button('<i class="fa fa-save"></i> Сохранить', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
