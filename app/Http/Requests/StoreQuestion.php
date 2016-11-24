<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestion extends FormRequest
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
            'subject' => 'required|exists:subjects,id',
            'content' => 'required',
            'type' => 'required|in:' . implode(',', config('options.question-type')),
            'answer.*.content' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'answer.*.content.max' => 'Answers must be less than :max characters.',
            'answer.*.content.required' => 'Answers must be required.',
        ];
    }
}
