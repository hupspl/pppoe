<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyKompartRequest;
use App\Http\Requests\StoreKompartRequest;
use App\Http\Requests\UpdateKompartRequest;
use App\Models\Kompart;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class KompartController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('kompart_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $komparts = Kompart::with(['media'])->get();

        return view('admin.komparts.index', compact('komparts'));
    }

    public function create()
    {
        abort_if(Gate::denies('kompart_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.komparts.create');
    }

    public function store(StoreKompartRequest $request)
    {
        $kompart = Kompart::create($request->all());

        foreach ($request->input('soft', []) as $file) {
            $kompart->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('soft');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $kompart->id]);
        }

        return redirect()->route('admin.komparts.index');
    }

    public function edit(Kompart $kompart)
    {
        abort_if(Gate::denies('kompart_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.komparts.edit', compact('kompart'));
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

        return redirect()->route('admin.komparts.index');
    }

    public function show(Kompart $kompart)
    {
        abort_if(Gate::denies('kompart_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.komparts.show', compact('kompart'));
    }

    public function destroy(Kompart $kompart)
    {
        abort_if(Gate::denies('kompart_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kompart->delete();

        return back();
    }

    public function massDestroy(MassDestroyKompartRequest $request)
    {
        $komparts = Kompart::find(request('ids'));

        foreach ($komparts as $kompart) {
            $kompart->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('kompart_create') && Gate::denies('kompart_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Kompart();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
