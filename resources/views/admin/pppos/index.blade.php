@extends('layouts.admin')
@section('content')
@can('pppo_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.pppos.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.pppo.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Pppo', 'route' => 'admin.pppos.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.pppo.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Pppo">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.login') }}
                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.password') }}
                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.ip_user') }}
                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.mac') }}
                        </th>
                        <th>
                            {{ trans('cruds.pppo.fields.updated_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pppos as $key => $pppo)
                        <tr data-entry-id="{{ $pppo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $pppo->id ?? '' }}
                            </td>
                            <td>
                                {{ $pppo->name ?? '' }}
                            </td>
                            <td>
                                {{ $pppo->login ?? '' }}
                            </td>
                            <td>
                                {{ $pppo->password ?? '' }}
                            </td>
                            <td>
                                {{ $pppo->ip_user ?? '' }}
                            </td>
                            <td>
                                {{ $pppo->mac ?? '' }}
                            </td>
                            <td>
                                {{ $pppo->updated_at ?? '' }}
                            </td>
                            <td>
                                @can('pppo_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.pppos.show', $pppo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('pppo_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.pppos.edit', $pppo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('pppo_delete')
                                    <form action="{{ route('admin.pppos.destroy', $pppo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('pppo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.pppos.massDestroy') }}",
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
  let table = $('.datatable-Pppo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection