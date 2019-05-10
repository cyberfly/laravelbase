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

Breadcrumbs::for('admin.users.show', function ($trail, $user_id) {
    $trail->parent('admin.users.index');
    $trail->push('Show User', route('admin.users.show', $user_id));
});

Breadcrumbs::for('admin.users.edit', function ($trail, $user_id) {
    $trail->parent('admin.users.index');
    $trail->push('Edit User', route('admin.users.edit', $user_id));
});

// roles

Breadcrumbs::for('admin.roles.index', function ($trail) {
    $trail->push('Manage Roles', route('admin.roles.index'));
});

Breadcrumbs::for('admin.roles.create', function ($trail) {
    $trail->parent('admin.roles.index');
    $trail->push('Create Role', route('admin.roles.create'));
});

Breadcrumbs::for('admin.roles.show', function ($trail, $role_id) {
    $trail->parent('admin.roles.index');
    $trail->push('Show Role', route('admin.roles.show', $role_id));
});

Breadcrumbs::for('admin.roles.edit', function ($trail, $role_id) {
    $trail->parent('admin.roles.index');
    $trail->push('Edit Role', route('admin.roles.edit', $role_id));
});

// notifications

Breadcrumbs::for('usernotifications.index', function ($trail) {
    $trail->push(__('labels.notifications'), route('usernotifications.index'));
});