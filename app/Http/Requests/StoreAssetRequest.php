<?php

namespace App\Http\Requests;

use App\Models\Asset;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreAssetRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('asset_create');
    }

    public function rules()
    {
        return [
            'category_id' => [
                'required',
                'integer',
            ],
            'serial_number' => [
                'string',
                'nullable',
            ],
            'name' => [
                'string',
                'required',
            ],
            'ip' => [
                'string',
                'min:0',
                'nullable',
            ],
            'soft_beckup' => [
                'array',
            ],
            'photos' => [
                'array',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
            'location_id' => [
                'required',
                'integer',
            ],
            'date_service' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
