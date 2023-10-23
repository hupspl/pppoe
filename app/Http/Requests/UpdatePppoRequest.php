<?php

namespace App\Http\Requests;

use App\Models\Pppo;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePppoRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('pppo_edit');
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
                'unique:pppos,ip_user,' . request()->route('pppo')->id,
            ],
            'mac' => [
                'string',
                'nullable',
            ],
        ];
    }
}
