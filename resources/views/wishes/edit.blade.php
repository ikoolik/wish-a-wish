@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Изменить желание</h1>
            {{ Form::model($wish, ['method' => 'PUT', 'route' => ['wishes.update', $wish->id], 'files' => true]) }}
            <div class="row">
                <div class="col-md-3">
                    <label>Картинка</label>
                    <div id="image-preview-wrapper">
                        <div class="img-thumbnail" id="image-preview" style="background-image: url('{{ $wish->image }}') ">
                        </div>
                        <label for="image-input" class="btn btn-default btn-block">Заменить картинку</label>
                        {{ Form::file('image', ['class' => 'hidden', 'id' => 'image-input']) }}
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Название</label>
                        {{ Form::text('name', $wish->name, ['class' => 'form-control', 'placeholder' => 'Феррари']) }}
                    </div>
                    <div class="form-group">
                        <label>Комментарий</label>
                        {{ Form::textarea('description', $wish->description, ['class' => 'form-control', 'placeholder' => 'Обязательно красного цвета']) }}
                    </div>
                    <hr>
                    {{ Form::button('<i class="fa fa-save"></i> Сохранить', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
