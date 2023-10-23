<?php

namespace App\Http\Requests;

use App\Models\Kompartnadajniki;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreKompartnadajnikiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('kompartnadajniki_create');
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
                'unique:kompartnadajnikis',
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
