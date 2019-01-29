@extends('layouts.backend')

@section('css_before')

@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Example: Multi Form</h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Examples</li>
                        <li class="breadcrumb-item active" aria-current="page">Blank</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content">

        <!-- Your Block -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title">Multi Form Information <small>Use this example when you want to customize array of data, such as data imported from CSV / Excel, before submit into database</small></h3>
            </div>
            <div class="block-content">

                <v-example-multiform-parent :users="{{ json_encode($users) }}" inline-template>

                    <div>

                        <!-- validation error -->

                        <v-parent-validation-alert
                                :submitted="submitted"
                                :show_error_details="false"
                        ></v-parent-validation-alert>

                        <!-- parent component form -->

                        <form @submit.prevent="handleSubmit">

                            <div class="row">

                                <!--include VueJS child component-->

                                @include('examples.multiforms.partials.v-multiform-child')

                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-secondary">Save</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>

                    </div>



                </v-example-multiform-parent>


            </div>
        </div>
        <!-- END Your Block -->



    </div>
    <!-- END Page Content -->

@endsection