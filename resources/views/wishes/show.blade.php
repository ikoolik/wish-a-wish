@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $wish->name }}</h1>
            <div class="row">
                <div class="col-md-3">
                    <img src="{{ $wish->image }}" class="img-thumbnail">
                </div>
                <div class="col-md-7">
                    <div>
                        @if(!$wish->description)
                            <i>Комментарий отсутствует</i>
                        @else
                            {!! $wish->description !!}
                        @endif
                    </div>

                    <hr>
                    @can('update', $wish)
                        <a class="btn btn-default" href="{{ route('wishes.edit', $wish->id) }}"><i class="fa fa-pencil"></i> Изменить</a>
                    @endcan
                </div>
                <div class="col-md-2">
                    @can('delete', $wish)
                        {{ Form::open(['method' => 'DELETE', 'route' => ['wishes.destroy', $wish->id], 'class' => 'form-inline']) }}
                        {{ Form::button('<i class="fa fa-trash"></i> Удалить', ['type' => 'submit', 'class' => 'btn btn-danger']) }}
                        {{ Form::close() }}
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
