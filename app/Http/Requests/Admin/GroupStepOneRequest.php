<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GroupStepOneRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'group_name' => [
                'required',
                'string',
                'max:255',
                'unique:groups,name'
            ],
            'start_date' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'end_date' => [
                'required',
                'date',
                'after:start_date'
            ],
            'enrollment_start_at' => [
                'required',
                'date',
                'before_or_equal:start_date'
            ],
            'enrollment_end_at' => [
                'required',
                'date',
                'after:enrollment_start_at',
                'before_or_equal:start_date'
            ]
        ];
    }

    public function messages()
    {
        return [
            'group_name.required' => __('El nombre del ciclo escolar es obligatorio'),
            'group_name.unique' => __('Este nombre de ciclo escolar ya existe'),
            'group_name.max' => __('El nombre no puede exceder 255 caracteres'),
            'start_date.required' => __('La fecha de inicio del ciclo es obligatoria'),
            'start_date.after_or_equal' => __('La fecha de inicio debe ser hoy o posterior'),
            'end_date.required' => __('La fecha de fin del ciclo es obligatoria'),
            'end_date.after' => __('La fecha de fin debe ser posterior a la fecha de inicio'),
            'enrollment_start_at.required' => __('La fecha de inicio de inscripciones es obligatoria'),
            'enrollment_start_at.before_or_equal' => __('Las inscripciones no pueden empezar después del ciclo'),
            'enrollment_end_at.required' => __('La fecha de fin de inscripciones es obligatoria'),
            'enrollment_end_at.after' => __('La fecha de fin debe ser posterior a la fecha de inicio de inscripciones'),
            'enrollment_end_at.before_or_equal' => __('Las inscripciones deben terminar antes del inicio del ciclo'),
        ];
    }
}
