<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Lalukan check
        // Baawaam dari laravel akibat middleware
        // Dapatkan data user
        // Jika terdapat user, boleh masuk ke request
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
            // Validation
            "name" => ['nullable','max:100'],
            "password" => ["nullable", 'max:100']
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
