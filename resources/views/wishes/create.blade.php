@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Новое желание</h1>
            {{ Form::open(['route' => ['wishes.store'], 'files' => true]) }}
            <div class="row">
                <div class="col-md-3">
                    <label>Картинка</label>
                    <div id="image-preview" class="img-thumbnail" style="background-image: url('http://previews.123rf.com/images/naddya/naddya1311/naddya131100064/24188141-Gift-box-Vector-black-silhouette--Stock-Vector-gift.jpg') ">
                    </div>
                    <label for="image-input" class="btn btn-default btn-block">Выбрать картинку</label>
                    {{ Form::file('image', ['class' => 'hidden', 'id' => 'image-input']) }}
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Название</label>
                        {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Феррари']) }}
                    </div>
                    <div class="form-group">
                        <label>Комментарий</label>
                        {{ Form::textarea('description', '', ['class' => 'form-control', 'placeholder' => 'Обязательно красного цвета']) }}
                    </div>
                    <hr>
                    {{ Form::button('<i class="fa fa-save"></i> Сохранить', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                    {{ Form::close() }}
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
