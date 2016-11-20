@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                @if(Auth::check() && Auth::user()->id === $user->id)
                    <div class="col-sm-4 col-md-3">
                        <div class="panel panel-default material">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Новое желание
                                </h3>
                            </div>
                            <a href="{{ route('wishes.create') }}">
                                <div class="square-image" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/0/03/Plus_sign_font_awesome.svg/512px-Plus_sign_font_awesome.svg.png');"></div>
                            </a>
                        </div>
                    </div>
                @endif
                @foreach($wishes as $wish)
                        <div class="col-sm-4 col-md-3">
                            <div class="panel panel-default material disabled">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        {{ $wish->name }}
                                    </h3>
                                </div>
                                @if($wish->isBooked())
                                    <span class="label label-danger label-booked">Забронировано</span>
                                @endif
                                <a href="{{ route('wishes.show', $wish->id) }}">
                                    <div class="square-image{{ $wish->isBooked() ? ' is-booked' : '' }}" style="background-image: url('{{ $wish->image }}')"></div>
                                </a>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
