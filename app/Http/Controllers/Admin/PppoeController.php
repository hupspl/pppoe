<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPppoRequest;
use App\Http\Requests\StorePppoRequest;
use App\Http\Requests\UpdatePppoRequest;
use App\Models\Pppo;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class PppoeController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('pppo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pppos = Pppo::all();

        return view('admin.pppos.index', compact('pppos'));
    }

    public function create()
    {
        abort_if(Gate::denies('pppo_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pppos.create');
    }

    public function store(StorePppoRequest $request)
    {
        $pppo = Pppo::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $pppo->id]);
        }

        return redirect()->route('admin.pppos.index');
    }

    public function edit(Pppo $pppo)
    {
        abort_if(Gate::denies('pppo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pppos.edit', compact('pppo'));
    }

    public function update(UpdatePppoRequest $request, Pppo $pppo)
    {
        $pppo->update($request->all());

        return redirect()->route('admin.pppos.index');
    }

    public function show(Pppo $pppo)
    {
        abort_if(Gate::denies('pppo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.pppos.show', compact('pppo'));
    }

    public function destroy(Pppo $pppo)
    {
        abort_if(Gate::denies('pppo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pppo->delete();

        return back();
    }

    public function massDestroy(MassDestroyPppoRequest $request)
    {
        $pppos = Pppo::find(request('ids'));

        foreach ($pppos as $pppo) {
            $pppo->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('pppo_create') && Gate::denies('pppo_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Pppo();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
