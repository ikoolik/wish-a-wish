<?php


Breadcrumbs::register('users.show', function($breadcrumbs, \Wish\User $user) {
    $breadcrumbs->push($user->name, route('users.show', $user));
});

// My Wishes
Breadcrumbs::register('wishes.index', function($breadcrumbs)
{
    $breadcrumbs->parent('users.show', auth()->user());
    $breadcrumbs->push('Желания', route('wishes.index'));
});

// Someones Wishes
Breadcrumbs::register('wishes.user_index', function($breadcrumbs, \Wish\User $user)
{
    $breadcrumbs->parent('users.show', $user);
    $breadcrumbs->push('Желания', route('wishes.user_index', $user->slug));
});

Breadcrumbs::register('wishes.show', function($breadcrumbs, \Wish\Wish $wish)
{
    $breadcrumbs->parent('wishes.user_index', $wish->owner);
    $breadcrumbs->push($wish->name, route('wishes.show', $wish->id));
});

Breadcrumbs::register('wishes.edit', function($breadcrumbs, \Wish\Wish $wish)
{
    $breadcrumbs->parent('wishes.show', $wish);
    $breadcrumbs->push("Изменить", route('wishes.edit', $wish->id));
});

Breadcrumbs::register('wishes.create', function($breadcrumbs)
{
    $breadcrumbs->parent('wishes.index');
    $breadcrumbs->push('Создать', route('wishes.create'));
});


