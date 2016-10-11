@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $user->name }}</h1>
            <div class="row">
                <div class="col-md-3 col-xs-8 col-xs-offset-2 col-md-offset-0">
                    <div class="square-image material" style="background-image: url('{{ $user->avatarUrl() }}')">
                    </div>
                </div>
                <div class="col-md-7 col-xs-12">
                    <p>Дата регистрации {{ $user->created_at->format('d.m.Y') }}</p>
                    <p>
                        <a href="{{ route('wishes.user_index', $user->slug) }}">
                            Желания ({{ $user->wishes()->notArchived()->count() }})
                        </a>
                    </p>
                    @can('update', $user)
                        <hr>
                        <a class="btn btn-default" href="{{ route('users.edit', $user->slug) }}"><i class="fa fa-pencil"></i> Изменить</a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
