@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.pppo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pppos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.id') }}
                        </th>
                        <td>
                            {{ $pppo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.name') }}
                        </th>
                        <td>
                            {{ $pppo->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.login') }}
                        </th>
                        <td>
                            {{ $pppo->login }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.password') }}
                        </th>
                        <td>
                            {{ $pppo->password }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.ip_user') }}
                        </th>
                        <td>
                            {{ $pppo->ip_user }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.mac') }}
                        </th>
                        <td>
                            {{ $pppo->mac }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.notka') }}
                        </th>
                        <td>
                            {!! $pppo->notka !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.pppo.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $pppo->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.pppos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection