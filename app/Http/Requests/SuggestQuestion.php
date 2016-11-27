<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuggestQuestion extends FormRequest
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
            'content' => 'required',
            'type' => 'required|in:' . implode(',', config('options.question-type')),
            'subject' => 'required|exists:subjects,id',
            'answer.*.content' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'answer.*.content.max' => trans('front-end/users.suggest-question.answer-content-max'),
            'answer.*.content.required' => trans('front-end/users.suggest-question.answer-content-required'),
        ];
    }
}
