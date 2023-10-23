<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StorePppoRequest;
use App\Http\Requests\UpdatePppoRequest;
use App\Http\Resources\Admin\PppoResource;
use App\Models\Pppo;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PppoeApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('pppo_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PppoResource(Pppo::all());
    }

    public function store(StorePppoRequest $request)
    {
        $pppo = Pppo::create($request->all());

        return (new PppoResource($pppo))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Pppo $pppo)
    {
        abort_if(Gate::denies('pppo_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PppoResource($pppo);
    }

    public function update(UpdatePppoRequest $request, Pppo $pppo)
    {
        $pppo->update($request->all());

        return (new PppoResource($pppo))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Pppo $pppo)
    {
        abort_if(Gate::denies('pppo_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $pppo->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
