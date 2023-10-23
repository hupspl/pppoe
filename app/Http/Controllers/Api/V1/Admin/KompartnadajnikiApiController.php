<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreKompartnadajnikiRequest;
use App\Http\Requests\UpdateKompartnadajnikiRequest;
use App\Http\Resources\Admin\KompartnadajnikiResource;
use App\Models\Kompartnadajniki;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KompartnadajnikiApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('kompartnadajniki_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KompartnadajnikiResource(Kompartnadajniki::all());
    }

    public function store(StoreKompartnadajnikiRequest $request)
    {
        $kompartnadajniki = Kompartnadajniki::create($request->all());

        foreach ($request->input('soft', []) as $file) {
            $kompartnadajniki->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('soft');
        }

        return (new KompartnadajnikiResource($kompartnadajniki))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Kompartnadajniki $kompartnadajniki)
    {
        abort_if(Gate::denies('kompartnadajniki_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new KompartnadajnikiResource($kompartnadajniki);
    }

    public function update(UpdateKompartnadajnikiRequest $request, Kompartnadajniki $kompartnadajniki)
    {
        $kompartnadajniki->update($request->all());

        if (count($kompartnadajniki->soft) > 0) {
            foreach ($kompartnadajniki->soft as $media) {
                if (! in_array($media->file_name, $request->input('soft', []))) {
                    $media->delete();
                }
            }
        }
        $media = $kompartnadajniki->soft->pluck('file_name')->toArray();
        foreach ($request->input('soft', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $kompartnadajniki->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('soft');
            }
        }

        return (new KompartnadajnikiResource($kompartnadajniki))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Kompartnadajniki $kompartnadajniki)
    {
        abort_if(Gate::denies('kompartnadajniki_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kompartnadajniki->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
