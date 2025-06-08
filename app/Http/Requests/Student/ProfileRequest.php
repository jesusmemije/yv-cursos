<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        $rules = [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'phone_number' => ['required'],
            'gender' => ['required', 'string'],
        ];

        // Si es necesario validar la imagen con restricciones
        if (! $this->shouldSkipImageValidation()) {
            $rules['image'] = 'mimes:jpeg,png,jpg|dimensions:min_width=300,min_height=300,max_width=300,max_height=300|max:1024';
        } else {
            $rules['image'] = 'mimes:jpeg,png,jpg|max:1024';
        }

        return $rules;
    }

    protected function shouldSkipImageValidation()
    {
        // Para esta ruto no se validará las dimenciones, porque queremos recortar la imagen.
        return $this->routeIs('student.save-profile');
    }
}
