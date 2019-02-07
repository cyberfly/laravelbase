<?php

namespace App\Http\Controllers;

use App\Http\Resources\Common\UploadResource;
use App\Models\Common\Upload;
use App\Traits\Attachable;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;

class UploadController extends Controller
{
    use Attachable;

    protected $upload;
    protected $media;

    public function __construct(Upload $upload, Media $media)
    {
        $this->upload = $upload;
        $this->media = $media;
    }

    public function store(Request $request, $collection_name)
    {
        $upload_model = $this->getUploadModel($request);

        $uploaded_files = $this->uploadAttachments($upload_model, $request, $collection_name, 'files');

        return (new UploadResource($upload_model))->additional([
            'uploaded_files' => $uploaded_files
        ]);
    }

    public function destroy(Request $request, $attachment_id)
    {
        $media = $this->media->find($attachment_id);

        $model_id = $media->model_id;
        $model_type = $media->model_type;

        $associated_model = $model_type::where('id', $model_id)->first();

        $associated_model->deleteMedia($attachment_id);

        return response('',204);
    }

    private function getUploadModel($request)
    {
        // if user specify the model to attach uploaded files

        if ($request->filled('model_type') && $request->filled('model_id')) {

            $model_id = $request->model_id;
            $model_type = $request->model_type;

            $associated_model = $model_type::where('id', $model_id)->first();

            if ($associated_model) {
                return $associated_model;
            }
        }

        // else, attached to temporary Upload model

        $this->upload->description = 'Ajax file upload, attached to temporary Upload model';

        $this->upload->save();

        return $this->upload;
    }
}
