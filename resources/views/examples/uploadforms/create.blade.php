@extends('layouts.backend')

@section('css_before')

@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">Example: Upload Form</h1>
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
                <h3 class="block-title">Upload Form <small>Use this example when you want to create a form with multiple file uploads</small></h3>
            </div>
            <div class="block-content">

                <v-example-upload-form inline-template>

                    <div>

                        <!-- parent component form -->

                        <form @submit.prevent="handleSubmit">

                            <div class="row">

                                <div class="col-lg-6">

                                    <div class="form-group">
                                        <v-text
                                                v-model="gallery_data.title"
                                                :field_name="'title'"
                                                :label="'Gallery Title'"
                                                :rules="'required'"
                                        ></v-text>
                                    </div>

                                    <div class="form-group">
                                        <v-text
                                                v-model="gallery_data.description"
                                                :field_name="'description'"
                                                :label="'Gallery Description'"
                                                :rules="'required'"
                                        ></v-text>
                                    </div>

                                    <div class="form-group">
                                        <v-upload
                                                v-model="gallery_data.cover_images"
                                                :field_name="'cover_images'"
                                                :label="'Cover Images'"
                                                :rules="'required'"
                                                :limit="2"
                                                v-validate="'required'"
                                                data-vv-name="cover_images"
                                        ></v-upload>
                                        <div class="invalid-feedback">@{{ errors.first('cover_images') }}</div>
                                    </div>

                                    <div class="form-group">
                                        <v-upload
                                                v-model="gallery_data.gallery_images"
                                                :field_name="'gallery_images'"
                                                :label="'Gallery Images'"
                                                :rules="'required'"
                                                v-validate="'required'"
                                                data-vv-name="gallery_images"
                                        ></v-upload>
                                        <div class="invalid-feedback">@{{ errors.first('gallery_images') }}</div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-secondary">Save</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>

                    </div>



                </v-example-upload-form>

            </div>
        </div>
        <!-- END Your Block -->

    </div>
    <!-- END Page Content -->

@endsection