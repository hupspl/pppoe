@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.kompart.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.komparts.update", [$kompart->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.kompart.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $kompart->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ip_user">{{ trans('cruds.kompart.fields.ip_user') }}</label>
                <input class="form-control {{ $errors->has('ip_user') ? 'is-invalid' : '' }}" type="text" name="ip_user" id="ip_user" value="{{ old('ip_user', $kompart->ip_user) }}" required>
                @if($errors->has('ip_user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ip_user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.ip_user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mac">{{ trans('cruds.kompart.fields.mac') }}</label>
                <input class="form-control {{ $errors->has('mac') ? 'is-invalid' : '' }}" type="text" name="mac" id="mac" value="{{ old('mac', $kompart->mac) }}">
                @if($errors->has('mac'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mac') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.mac_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="login">{{ trans('cruds.kompart.fields.login') }}</label>
                <input class="form-control {{ $errors->has('login') ? 'is-invalid' : '' }}" type="text" name="login" id="login" value="{{ old('login', $kompart->login) }}">
                @if($errors->has('login'))
                    <div class="invalid-feedback">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.login_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="password">{{ trans('cruds.kompart.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="text" name="password" id="password" value="{{ old('password', $kompart->password) }}">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="soft">{{ trans('cruds.kompart.fields.soft') }}</label>
                <div class="needsclick dropzone {{ $errors->has('soft') ? 'is-invalid' : '' }}" id="soft-dropzone">
                </div>
                @if($errors->has('soft'))
                    <div class="invalid-feedback">
                        {{ $errors->first('soft') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.soft_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="datasoftu">{{ trans('cruds.kompart.fields.datasoftu') }}</label>
                <input class="form-control date {{ $errors->has('datasoftu') ? 'is-invalid' : '' }}" type="text" name="datasoftu" id="datasoftu" value="{{ old('datasoftu', $kompart->datasoftu) }}">
                @if($errors->has('datasoftu'))
                    <div class="invalid-feedback">
                        {{ $errors->first('datasoftu') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.datasoftu_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notka">{{ trans('cruds.kompart.fields.notka') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('notka') ? 'is-invalid' : '' }}" name="notka" id="notka">{!! old('notka', $kompart->notka) !!}</textarea>
                @if($errors->has('notka'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notka') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.kompart.fields.notka_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    var uploadedSoftMap = {}
Dropzone.options.softDropzone = {
    url: '{{ route('admin.komparts.storeMedia') }}',
    maxFilesize: 20, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 20
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="soft[]" value="' + response.name + '">')
      uploadedSoftMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedSoftMap[file.name]
      }
      $('form').find('input[name="soft[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($kompart) && $kompart->soft)
          var files =
            {!! json_encode($kompart->soft) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="soft[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.komparts.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $kompart->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection