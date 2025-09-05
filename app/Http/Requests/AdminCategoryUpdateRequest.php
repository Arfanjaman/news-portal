<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        //jeita update korbo oita unique hou jabe na tai oita route er querystring ba parameter theke niye nite hobe
        $categoryId = $this->route('category'); // 'category' is the route parameter name
        return [

            'name' => ['required', 'max:255', 'unique:categories,name,'.$categoryId],
            'show_at_nav' => ['required', 'boolean'],
            'language' => ['required'],
            'status' => ['required', 'boolean']
        ];
    }
}
