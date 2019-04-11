<?php

namespace App\Http\Controllers\Example;

use App\Http\Resources\Example\GalleryResource;
use App\Models\Example\Gallery;
use App\Traits\Attachable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadFormController extends Controller
{
    use Attachable;

    public function create()
    {
        return view('examples.uploadforms.create');
    }

    /**
     * @param Request $request
     * @return GalleryResource
     */
    public function store(Request $request)
    {
        // store the form data

        $gallery = Gallery::create($request->only('title', 'description'));

        // sync the attachment with created model

        $this->syncAttachedMedia($gallery, $request);

        // get uploaded attachments to include in response

        $uploaded_files = $this->getAllModelAttachments($gallery);
        $attached_media_id = $this->getAttachedMediaId($gallery);

        return (new GalleryResource($gallery))->additional([
            'uploaded_files' => $uploaded_files,
            'attached_media_id' => $attached_media_id,
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $gallery = Gallery::find($id);

        // get uploaded attachments to include in response

        $uploaded_files = $this->getAllModelAttachments($gallery);
        $attached_media_id = $this->getAttachedMediaId($gallery);

        return view('examples.uploadforms.edit', compact('gallery', 'uploaded_files', 'attached_media_id'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $gallery->update($request->all());

        $gallery->refresh();

        // sync the attachment with updated model

        $this->syncAttachedMedia($gallery, $request);

        // get uploaded attachments to include in response

        $uploaded_files = $this->getAllModelAttachments($gallery);
        $attached_media_id = $this->getAttachedMediaId($gallery);

        return (new GalleryResource($gallery))->additional([
            'uploaded_files' => $uploaded_files,
            'attached_media_id' => $attached_media_id,
        ]);
    }
}
