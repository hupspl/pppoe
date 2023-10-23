<?php

namespace App\Http\Requests;

use App\Models\Pppo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StorePppoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pppo_create');
    }

    public function rules()
    {
        return [
            'name' => [
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
            'ip_user' => [
                'string',
                'required',
                'unique:pppos',
            ],
            'mac' => [
                'string',
                'nullable',
            ],
        ];
    }
}
