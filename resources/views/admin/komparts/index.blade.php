@extends('layouts.admin')
@section('content')
@can('kompart_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.komparts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.kompart.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Kompart', 'route' => 'admin.komparts.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.kompart.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Kompart">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.ip_user') }}
                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.mac') }}
                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.login') }}
                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.password') }}
                        </th>
                        <th>
                            {{ trans('cruds.kompart.fields.soft') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($komparts as $key => $kompart)
                        <tr data-entry-id="{{ $kompart->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $kompart->id ?? '' }}
                            </td>
                            <td>
                                {{ $kompart->name ?? '' }}
                            </td>
                            <td>
                                {{ $kompart->ip_user ?? '' }}
                            </td>
                            <td>
                                {{ $kompart->mac ?? '' }}
                            </td>
                            <td>
                                {{ $kompart->login ?? '' }}
                            </td>
                            <td>
                                {{ $kompart->password ?? '' }}
                            </td>
                            <td>
                                @foreach($kompart->soft as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank">
                                        {{ trans('global.view_file') }}
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                @can('kompart_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.komparts.show', $kompart->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('kompart_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.komparts.edit', $kompart->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('kompart_delete')
                                    <form action="{{ route('admin.komparts.destroy', $kompart->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('kompart_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.komparts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'asc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-Kompart:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection