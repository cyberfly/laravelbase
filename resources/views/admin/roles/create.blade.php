@extends('layouts.backend')

@section('css_before')

@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Create Role</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    {{ Breadcrumbs::render('admin.roles.create') }}
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">
        <!-- Your Block -->
        <div class="block block-rounded block-bordered">
            <div id="test" class="block-header block-header-default">
                <h3 class="block-title">Role Information</h3>
            </div>
            <div class="block-content">
                <create-role-component
                        :permissions="{{ $permissions }}"
                ></create-role-component>
            </div>
        </div>
        <!-- END Your Block -->
    </div>
    <!-- END Page Content -->

@endsection