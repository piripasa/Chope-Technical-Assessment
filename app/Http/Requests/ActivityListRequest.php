<?php

namespace App\Http\Requests;

class ActivityListRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'integer|min:1',
            'perPage' => 'integer|min:1|max:25'
        ];
    }
}
