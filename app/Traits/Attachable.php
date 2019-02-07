<?php

namespace App\Traits;

use Spatie\MediaLibrary\Models\Media;

trait Attachable
{
    /**
     * Sync attached media to current model. Use this if you ajax upload.
     * This will sync media from temporary Upload Model, to current model that you choose
     * @param $model
     * @param $request
     */
    public function syncAttachedMedia($model, $request)
    {
        if ($request->filled('attached_media')) {

            foreach ($request->attached_media as $media_id) {

                $media = Media::find($media_id);

                // associate media with new model

                if ($media) {

                    $media->model_type = get_class($model);
                    $media->model_id = $model->id;

                    $media->save();

                }
            }
        }
    }


    /**
     * Sync attachments with new attachments and delete attachment
     * Suitable for update form with existing attachments to sync
     * @param $model
     * @param $request
     * @param string $media_collection
     */
    public function syncAttachments($model, $request, $media_collection='attachments')
    {
        // attached new files

        $this->uploadAttachments($model, $request, $media_collection);

        // removed selected files to delete

        $this->deleteAttachments($request->deleted_files);
    }

    /**
     * Upload attachments, default will attach to collection name attachments
     * @param $model
     * @param $request
     * @param string $media_collection
     * @param null $input_key
     * @return array
     */
    public function uploadAttachments($model, $request, $media_collection='attachments', $input_key=null)
    {
        if (empty($input_key)) {
            $input_key = $media_collection;
        }

        $uploaded_media = [];

        if ($request->hasFile($input_key)) {

            $files = $request->file($input_key);

            foreach ($files as $file) {

                $media = $model
                    ->addMedia($file)
                    ->toMediaCollection($media_collection);

                $transform_media = $this->transformMedia($media);

                $uploaded_media[$media_collection][] = $transform_media;
            }
        }

        return $uploaded_media;
    }

    /**
     * Delete specific media attachments
     * @param $deleted_files
     * @internal param $deleted_files
     */
    public function deleteAttachments($deleted_files)
    {
        Media::find($deleted_files)
            ->each
            ->delete();
    }

    /**
     * Get attachments by collection name, default will fetch collection name attachments
     * @param $model
     * @param string $media_collection
     * @return array
     */
    public function getAttachments($model, $media_collection='attachments')
    {
        return $this->getAttachedMedia($model, $media_collection);
    }

    /**
     * Sugarcoat Spatie GetMedia to decorate the response
     * @param $model
     * @param string $collection_name
     * @return array
     */
    private function getAttachedMedia($model, $collection_name='')
    {
        $uploaded_media = [];

        if (empty($collection_name)) {
            $uploaded_files = $model->getMedia();
        }
        else {
            $uploaded_files = $model->getMedia($collection_name);
        }

        if ($uploaded_files->count()) {

            foreach ($uploaded_files as $file) {

//                dd($file);

                $uploaded_media[] = [
                    'id' => $file->id,
                    'name' => $file->name,
                    'mime_type' => $file->mime_type,
                    'url' => $file->getFullUrl(),
                    'storage_path' => $file->getUrl(),
//                    'full_path' => $file->getPath(),
                ];
            }
        }

        return $uploaded_media;
    }

    /**
     * Get all attachments tied to model
     * @param $model
     * @return array
     */
    public function getAllModelAttachments($model)
    {
        $model_type = get_class($model);
        $model_id_key = $model->getKeyName();
        $model_id = $model->$model_id_key;

        $model_collection_names = Media::whereModelId($model_id)->whereModelType($model_type)->groupBy('collection_name')->pluck('collection_name')->toArray();

        $attachments = [];

        if (!empty($model_collection_names)) {
            foreach ($model_collection_names as $collection_name) {
                $collection_attachments = $this->getAttachedMedia($model, $collection_name);
                $attachments[$collection_name] = $collection_attachments;
            }
        }

        return $attachments;
    }

    /**
     * Get all media id that was attached to the model
     * @param $model
     * @return array
     */
    public function getAttachedMediaId($model)
    {
        $model_type = get_class($model);
        $model_id_key = $model->getKeyName();
        $model_id = $model->$model_id_key;

        $attached_media_id = Media::whereModelId($model_id)->whereModelType($model_type)->pluck('id')->toArray();

        return $attached_media_id;
    }

    /**
     * Transform media key for API consumption
     * @param $media
     * @return array
     */
    private function transformMedia($media)
    {
        $transform_media = [
            'id' => $media->id,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'url' => $media->getFullUrl(),
        ];

        return $transform_media;
    }
}