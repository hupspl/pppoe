<?php

namespace App\Http\Requests;

use App\Models\Kompartnadajniki;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateKompartnadajnikiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kompartnadajniki_edit');
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
                'unique:kompartnadajnikis,ip_user,' . request()->route('kompartnadajniki')->id,
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
            'date_soft' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
