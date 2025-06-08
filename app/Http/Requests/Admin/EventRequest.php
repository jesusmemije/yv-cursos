<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EventRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $uuid = $this->route('uuid'); 

        return [
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'event_category_id' => 'nullable|exists:event_categories,id',
            'image' => 'nullable|image|max:2048', // 2MB Max
            'location' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
            'time_zone' => 'required|string|max:100',
            'slug' => [
                'nullable',
                'string',
                Rule::unique('events')->ignore($uuid, 'uuid') // Ignora este evento por UUID en la validación de slug
            ],
            'tag_ids' => 'nullable|array',
            'tag_ids.*' => 'exists:tags,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'details.required' => 'Los detalles son obligatorios.',
            'location.required' => 'La ubicación es obligatoria.',
            'start.required' => 'La fecha de inicio es obligatoria.',
            'end.required' => 'La fecha de finalización es obligatoria y debe ser igual o posterior a la fecha de inicio.',
            'time_zone.required' => 'La zona horaria es obligatoria.',
            'event_category_id.exists' => 'La categoría seleccionada no es válida.',
            'tag_ids.*.exists' => 'Una o más de las etiquetas seleccionadas no son válidas.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.max' => 'La imagen no debe ser mayor de 2MB.'
        ];
    }
}
