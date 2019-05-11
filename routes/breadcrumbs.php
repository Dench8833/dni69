<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', route('home'));
});

// Admin
Breadcrumbs::for('admin', function ($trail) {
    $trail->push('Админ', route('admin'));
});

// Admin > Songs
Breadcrumbs::for('songs', function ($trail) {
    $trail->parent('admin');
    $trail->push('Песни', route('songs'));
});

// Admin > Songs > Create
Breadcrumbs::for('song.create', function ($trail) {
    $trail->parent('songs');
    $trail->push('Добавление', route('song.create'));
});

// Admin > Songs > Edit > [Id]
Breadcrumbs::for('song.edit', function ($trail, $id) {
    //dump($id);die;
    $song = \App\Models\Song::findOrfail($id);
    $trail->parent('songs');
    $trail->push('Редактирование: '.$song->name, route('song.edit', $id));
});

// Admin > Songs > Show
Breadcrumbs::for('song.show', function ($trail, $id) {
    $song = \App\Models\Song::findOrfail($id);
    $trail->parent('songs');
    $trail->push('Просмотр: '.$song->name, route('song.show', $id));
});

// Admin > Verses
Breadcrumbs::for('verses', function ($trail) {
    $trail->parent('admin');
    $trail->push('Стихи', route('verses'));
});

// Admin > Verse > Create
Breadcrumbs::for('verse.create', function ($trail) {
    $trail->parent('verses');
    $trail->push('Добавление', route('verse.create'));
});

// Admin > Verse > Edit
Breadcrumbs::for('verse.edit', function ($trail) {
    $trail->parent('verses');
    $trail->push('Редактирование', route('verse.edit'));
});

// Admin > Verse > Show
Breadcrumbs::for('verse.show', function ($trail) {
    $trail->parent('verses');
    $trail->push('Просмотр', route('verse.show'));
});


