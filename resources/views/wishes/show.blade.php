@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $wish->name }}</h1>
            <div class="row">
                <div class="col-sm-3">
                    <div class="square-image material" style="background-image: url('{{ $wish->image }}');"></div>
                    <div class="controll-buttons">
                        @can('update', $wish)
                            <a class="btn btn-block btn-default" href="{{ route('wishes.edit', $wish->id) }}"><i class="fa fa-pencil"></i> Изменить</a>
                        @endcan
                        @can('delete', $wish)
                            {{ Form::open(['method' => 'DELETE', 'route' => ['wishes.destroy', $wish->id], 'class' => 'form-inline']) }}
                            {{ Form::button('<i class="fa fa-trash"></i> Удалить', ['type' => 'submit', 'class' => 'btn btn-danger btn-block']) }}
                            {{ Form::close() }}
                        @endcan
                    </div>
                </div>
                <div class="col-md-9">
                    <div>
                        @if(!$wish->description)
                            <i>Комментарий отсутствует</i>
                        @else
                            {!! $wish->presenter()->description() !!}
                        @endif
                    </div>

                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
