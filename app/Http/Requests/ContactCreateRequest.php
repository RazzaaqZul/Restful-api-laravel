<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContactCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "first_name" => ['required', 'max:100'],
            "last_name" => ['nullable', 'max:100'],
            "email" => ['nullable', 'max:200', 'email'],
            "phone" => ['nullable', 'max:20'],
        ];
    }

    
     // Jika terjadi error akan throw pada form request akan dilempar ke ValidationException
    // kita mau dalam bentuk HTTP Response misalnya
    protected function failedValidation(Validator $validator)
    {
        // parameternya adalah response dan status code
        throw new HttpResponseException(response([
            // getMessageBag() otomatis akan di set error key valuenya
            "errors" => $validator->getMessageBag()
        ],400));
    }
}
