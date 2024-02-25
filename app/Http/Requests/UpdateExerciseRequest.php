<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExerciseRequest extends FormRequest
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
            'title',
            'date',
            'description',
            'lessontypes_id',
            'teachers_id',
            'groups_id',
            'semesters_id',
            'subjects_id',
            'topics_id',
            'educationyear_id',

        ];
    }
}
