<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyKompartnadajnikiRequest;
use App\Http\Requests\StoreKompartnadajnikiRequest;
use App\Http\Requests\UpdateKompartnadajnikiRequest;
use App\Models\Kompartnadajniki;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class KompartnadajnikiController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('kompartnadajniki_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kompartnadajnikis = Kompartnadajniki::with(['media'])->get();

        return view('admin.kompartnadajnikis.index', compact('kompartnadajnikis'));
    }

    public function create()
    {
        abort_if(Gate::denies('kompartnadajniki_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.kompartnadajnikis.create');
    }

    public function store(StoreKompartnadajnikiRequest $request)
    {
        $kompartnadajniki = Kompartnadajniki::create($request->all());

        foreach ($request->input('soft', []) as $file) {
            $kompartnadajniki->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('soft');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $kompartnadajniki->id]);
        }

        return redirect()->route('admin.kompartnadajnikis.index');
    }

    public function edit(Kompartnadajniki $kompartnadajniki)
    {
        abort_if(Gate::denies('kompartnadajniki_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.kompartnadajnikis.edit', compact('kompartnadajniki'));
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

        return redirect()->route('admin.kompartnadajnikis.index');
    }

    public function show(Kompartnadajniki $kompartnadajniki)
    {
        abort_if(Gate::denies('kompartnadajniki_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.kompartnadajnikis.show', compact('kompartnadajniki'));
    }

    public function destroy(Kompartnadajniki $kompartnadajniki)
    {
        abort_if(Gate::denies('kompartnadajniki_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kompartnadajniki->delete();

        return back();
    }

    public function massDestroy(MassDestroyKompartnadajnikiRequest $request)
    {
        $kompartnadajnikis = Kompartnadajniki::find(request('ids'));

        foreach ($kompartnadajnikis as $kompartnadajniki) {
            $kompartnadajniki->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('kompartnadajniki_create') && Gate::denies('kompartnadajniki_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Kompartnadajniki();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
