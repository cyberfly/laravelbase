<?php

// laravel-base breadcrumbs

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

Breadcrumbs::for('admin.users.index', function ($trail) {
    $trail->push('Manage Users', route('admin.users.index'));
});

Breadcrumbs::for('admin.users.create', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create User', route('admin.users.create'));
});

Breadcrumbs::for('admin.users.show', function ($trail) {
    $trail->parent('admin.users.index');
    $trail->push('Create User', route('admin.users.show'));
});