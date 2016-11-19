@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $wish->name }}</h1>
            <div class="row">
                <div class="col-sm-3 col-xs-8 col-xs-offset-2 col-sm-offset-0">
                    <div class="square-image material" style="background-image: url('{{ $wish->image }}');"></div>
                    <div class="controll-buttons hidden-xs">
                        @if($wish->isBooked())
                            <span class="btn btn-block" disabled>Желание забронировано</span>
                        @endif
                        @can('book', $wish)
                            {{ Form::open(['method' => 'POST', 'route' => ['wishes.book', $wish->id], 'class' => 'form-inline']) }}
                            {{ Form::button('<i class="fa fa-lock"></i> Забронировать', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
                            {{ Form::close() }}
                        @endcan
                        @can('unbook', $wish)
                            {{ Form::open(['method' => 'POST', 'route' => ['wishes.unbook', $wish->id], 'class' => 'form-inline']) }}
                            {{ Form::button('<i class="fa fa-unlock-alt"></i> Отменить бронь', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
                            {{ Form::close() }}
                        @endcan
                        @if($wish->isArchived())
                            <span class="btn btn-block" disabled>Подарено {{ $wish->archived_at->format('d.m.Y') }}</span>
                        @endif
                        @can('update', $wish)
                            @if(!$wish->isArchived())
                                {{ Form::open(['method' => 'POST', 'route' => ['wishes.archive', $wish->id], 'class' => 'form-inline']) }}
                                {{ Form::button('<i class="fa fa-gift"></i> Подарено', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
                                {{ Form::close() }}
                            @endif
                            <a class="btn btn-block btn-default" href="{{ route('wishes.edit', $wish->id) }}"><i class="fa fa-pencil"></i> Изменить</a>
                        @endcan
                        @can('delete', $wish)
                            {{ Form::open(['method' => 'DELETE', 'route' => ['wishes.destroy', $wish->id], 'class' => 'form-inline']) }}
                            {{ Form::button('<i class="fa fa-trash"></i> Удалить', ['type' => 'submit', 'class' => 'btn btn-danger btn-block']) }}
                            {{ Form::close() }}
                        @endcan
                    </div>
                </div>
                <div class="col-md-9 col-xs-12">
                    <div>
                        @if(!$wish->description)
                            <i>Комментарий отсутствует</i>
                        @else
                            {!! $wish->presenter()->description() !!}
                        @endif
                    </div>
                    <hr>
                </div>
                <div class="controll-buttons visible-xs col-xs-12">
                    @if($wish->isBooked())
                        <span class="btn btn-block" disabled>Желание забронировано</span>
                    @endif
                    @can('book', $wish)
                        {{ Form::open(['method' => 'POST', 'route' => ['wishes.archive', $wish->id], 'class' => 'form-inline']) }}
                        {{ Form::button('<i class="fa fa-lock"></i> Забронировать', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
                        {{ Form::close() }}
                    @endcan
                    @can('unbook', $wish)
                        {{ Form::open(['method' => 'POST', 'route' => ['wishes.unbook', $wish->id], 'class' => 'form-inline']) }}
                        {{ Form::button('<i class="fa fa-unlock-alt"></i> Отменить бронь', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
                        {{ Form::close() }}
                    @endcan
                    @if($wish->isArchived())
                        <span class="btn btn-block" disabled>Подарено {{ $wish->archived_at->format('d.m.Y') }}</span>
                    @endif
                    @can('update', $wish)
                        @if(!$wish->isArchived())
                            {{ Form::open(['method' => 'POST', 'route' => ['wishes.archive', $wish->id], 'class' => 'form-inline']) }}
                            {{ Form::button('<i class="fa fa-gift"></i> Подарено', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) }}
                            {{ Form::close() }}
                        @endif
                        <a class="btn btn-block btn-default" href="{{ route('wishes.edit', $wish->id) }}"><i class="fa fa-pencil"></i> Изменить</a>
                    @endcan
                    @can('delete', $wish)
                        {{ Form::open(['method' => 'DELETE', 'route' => ['wishes.destroy', $wish->id], 'class' => 'form-inline']) }}
                        {{ Form::button('<i class="fa fa-trash"></i> Удалить', ['type' => 'submit', 'class' => 'btn btn-danger btn-block']) }}
                        {{ Form::close() }}
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
