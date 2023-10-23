@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.pppo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.pppos.update", [$pppo->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="name">{{ trans('cruds.pppo.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $pppo->name) }}">
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pppo.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="login">{{ trans('cruds.pppo.fields.login') }}</label>
                <input class="form-control {{ $errors->has('login') ? 'is-invalid' : '' }}" type="text" name="login" id="login" value="{{ old('login', $pppo->login) }}">
                @if($errors->has('login'))
                    <div class="invalid-feedback">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pppo.fields.login_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="password">{{ trans('cruds.pppo.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="text" name="password" id="password" value="{{ old('password', $pppo->password) }}">
                @if($errors->has('password'))
                    <div class="invalid-feedback">
                        {{ $errors->first('password') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pppo.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ip_user">{{ trans('cruds.pppo.fields.ip_user') }}</label>
                <input class="form-control {{ $errors->has('ip_user') ? 'is-invalid' : '' }}" type="text" name="ip_user" id="ip_user" value="{{ old('ip_user', $pppo->ip_user) }}" required>
                @if($errors->has('ip_user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ip_user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pppo.fields.ip_user_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="mac">{{ trans('cruds.pppo.fields.mac') }}</label>
                <input class="form-control {{ $errors->has('mac') ? 'is-invalid' : '' }}" type="text" name="mac" id="mac" value="{{ old('mac', $pppo->mac) }}">
                @if($errors->has('mac'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mac') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pppo.fields.mac_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="notka">{{ trans('cruds.pppo.fields.notka') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('notka') ? 'is-invalid' : '' }}" name="notka" id="notka">{!! old('notka', $pppo->notka) !!}</textarea>
                @if($errors->has('notka'))
                    <div class="invalid-feedback">
                        {{ $errors->first('notka') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.pppo.fields.notka_helper') }}</span>
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
                xhr.open('POST', '{{ route('admin.pppos.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $pppo->id ?? 0 }}');
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