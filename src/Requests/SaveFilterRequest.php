<?php

namespace Polyloans\Filter\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveFilterRequest extends FormRequest
{
    /**
     * @var array
     */
    protected $dontFlash = ['_currentUser'];

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'filter_key' => 'required',
            'filter_url' => 'required',
            'filter_name' => 'required',
            'filter_data' => 'required',
        ];
    }
}
