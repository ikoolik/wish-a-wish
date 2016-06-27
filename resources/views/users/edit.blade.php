@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>Настройки пользователя</h1>
            {{ Form::model($user, ['method' => 'PUT', 'route' => ['users.update', $user->slug]]) }}
            <div class="row">
                <div class="col-md-3">
                    <div class="square-image material" style="background-image: url('{{ $user->avatarUrl() }}')">

                    </div>
                </div>
                <div class="col-md-7">
                    <div class="form-group">
                        <label>Имя</label>
                        {{ Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Василий']) }}
                    </div>
                    <div class="form-group">
                        <label>Код</label>
                        {{ Form::text('slug', $user->slug, ['class' => 'form-control', 'placeholder' => 'Vasiliy']) }}
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
