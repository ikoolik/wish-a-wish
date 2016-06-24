@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <h1>{{ $user->name }}</h1>
            <p>Дата регистрации {{ $user->created_at->format('Y.m.d') }}</p>
            <p>
                <a href="{{ route('wishes.user_index', $user->slug) }}">
                    Желания ({{ $user->wishes()->count() }})
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
