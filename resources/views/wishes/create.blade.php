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
                    <label>Картинка</label>
                    <file-picker current="/images/default.png"></file-picker>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Название</label>
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Феррари']) }}
                    </div>
                    <div class="form-group">
                        <label>Комментарий</label>
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Обязательно красного цвета']) }}
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
