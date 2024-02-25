<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMiddleexamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number',
            'examtypes_id',
            'groups_id',
            'subjects_id',
            'semesters_id',
            'start',
            'end',
            'attempts',
            'passing',
        ];
    }
}
