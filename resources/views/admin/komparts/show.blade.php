@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kompart.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.komparts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.id') }}
                        </th>
                        <td>
                            {{ $kompart->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.name') }}
                        </th>
                        <td>
                            {{ $kompart->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.ip_user') }}
                        </th>
                        <td>
                            {{ $kompart->ip_user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.mac') }}
                        </th>
                        <td>
                            {{ $kompart->mac }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.login') }}
                        </th>
                        <td>
                            {{ $kompart->login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.password') }}
                        </th>
                        <td>
                            {{ $kompart->password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.soft') }}
                        </th>
                        <td>
                            @foreach($kompart->soft as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.datasoftu') }}
                        </th>
                        <td>
                            {{ $kompart->datasoftu }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompart.fields.notka') }}
                        </th>
                        <td>
                            {!! $kompart->notka !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.komparts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection