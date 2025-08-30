<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUpdatePasswordRequest extends FormRequest
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
        return [
            'current_password' => ['required',  'max:255' ],
            'password' => ['required', 'min:8', 'confirmed'],
        ];
    }


    //custom validation to chek the password in admin table
      public function withValidator($validator): void
    {
        $validator->after(function($validator){
            if(!Hash::check($this->current_password, Auth::guard('admin')->user()->password)){
                $validator->errors()->add('current_password', __('old password doesn\'t match'));
            }
        });
    }



}
