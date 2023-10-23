<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreKompartRequest;
use App\Http\Requests\UpdateKompartRequest;
use App\Http\Resources\Admin\KompartResource;
use App\Models\Kompart;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KompartApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('kompart_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KompartResource(Kompart::all());
    }

    public function store(StoreKompartRequest $request)
    {
        $kompart = Kompart::create($request->all());

        foreach ($request->input('soft', []) as $file) {
            $kompart->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('soft');
        }

        return (new KompartResource($kompart))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Kompart $kompart)
    {
        abort_if(Gate::denies('kompart_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KompartResource($kompart);
    }

    public function update(UpdateKompartRequest $request, Kompart $kompart)
    {
        $kompart->update($request->all());

        if (count($kompart->soft) > 0) {
            foreach ($kompart->soft as $media) {
                if (! in_array($media->file_name, $request->input('soft', []))) {
                    $media->delete();
                }
            }
        }
        $media = $kompart->soft->pluck('file_name')->toArray();
        foreach ($request->input('soft', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $kompart->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('soft');
            }
        }

        return (new KompartResource($kompart))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Kompart $kompart)
    {
        abort_if(Gate::denies('kompart_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kompart->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
