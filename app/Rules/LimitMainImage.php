<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\MainImage;

class LimitMainImage implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return MainImage::count() < 4; // Permitir solo si hay menos de 4 registros
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'No se pueden agregar más de 4 registros. Si deseas modificar un registro, elimínalo y agrégalo de nuevo.';
    }
}
