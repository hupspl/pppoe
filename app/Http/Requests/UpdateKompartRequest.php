<?php

namespace App\Http\Requests;

use App\Models\Kompart;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateKompartRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kompart_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'ip_user' => [
                'string',
                'required',
                'unique:komparts,ip_user,' . request()->route('kompart')->id,
            ],
            'mac' => [
                'string',
                'nullable',
            ],
            'login' => [
                'string',
                'nullable',
            ],
            'password' => [
                'string',
                'nullable',
            ],
            'soft' => [
                'array',
            ],
            'datasoftu' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
