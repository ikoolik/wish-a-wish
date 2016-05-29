@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                @if(Auth::check() && Auth::user()->id === $user->id)
                    <div class="col-md-4">
                        <div class="panel panel-default wish">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Новое желание
                                </h3>
                            </div>
                            <div class="panel-body" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Plus_sign_font_awesome.svg/512px-Plus_sign_font_awesome.svg.png');"></div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('wishes.create') }}">Добавить</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @foreach($wishes as $wish)
                    <div class="col-md-4">
                        <div class="panel panel-default wish">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    {{ $wish->name }}
                                </h3>
                            </div>
                            <div class="panel-body" style="background-image: url('{{ $wish->image }}');"></div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="{{ route('wishes.show', $wish->id) }}">Смотреть</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
