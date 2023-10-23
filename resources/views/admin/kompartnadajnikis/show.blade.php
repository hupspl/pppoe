@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kompartnadajniki.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kompartnadajnikis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.id') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.name') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.ip_user') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->ip_user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.mac') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->mac }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.login') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.password') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.soft') }}
                        </th>
                        <td>
                            @foreach($kompartnadajniki->soft as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.date_soft') }}
                        </th>
                        <td>
                            {{ $kompartnadajniki->date_soft }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kompartnadajniki.fields.notka') }}
                        </th>
                        <td>
                            {!! $kompartnadajniki->notka !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kompartnadajnikis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection