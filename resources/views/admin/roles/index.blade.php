@extends('layouts.backend')

@section('css_before')

@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Manage Roles</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">R</li>
                        <li class="breadcrumb-item active" aria-current="page">Blank</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <div class="form-group">
                    <div class="input-group">
                        <a class="btn btn-icon btn-primary" href="{{ route('admin.roles.create') }}" style="width:100%">
                            <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
                            <span class="btn-inner--text">Add New</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">

        <index-role-component></index-role-component>

    </div>
    <!-- END Page Content -->

@endsection