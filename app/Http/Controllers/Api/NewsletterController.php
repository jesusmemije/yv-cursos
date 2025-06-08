<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Newsletter\Facades\Newsletter;
use Illuminate\Support\Facades\Log;

class NewsletterController extends Controller
{   
    /**
     * Suscribe un usuario a la lista de próximos cursos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribeToCourses(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'name' => 'required|string',
            'phone' => ['required', 'digits:10'],
        ]);

        return $this->subscribe('upcoming_courses', $$request->email, [
            'FNAME' => $request->name,
            'PHONE' => $request->phone,
        ]);
    }

    /**
     * Suscribe un usuario a la lista de próximas publicaciones.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function subscribeToPosts(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        return $this->subscribe('upcoming_posts', $request->email);
    }

    /**
     * Realiza la suscripción a una lista de Mailchimp.
     *
     * @param string $listName Nombre de la lista de Mailchimp.
     * @param string $email Correo electrónico del suscriptor.
     * @param array $mergeFields Campos adicionales (por ejemplo, nombre, teléfono).
     * @return bool True si se suscribió correctamente, false en caso contrario.
     */
    private function subscribe(string $listName, string $email, array $mergeFields = [])
    {
        if (Newsletter::hasMember($email, $listName)) {
            return response()->json([
                'success' => false,
                'message' => 'Este correo ya está suscrito.',
            ], 409);
        }

        try {
            $result = Newsletter::subscribeOrUpdate($email, $mergeFields, $listName);

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Te has suscrito exitosamente!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No se pudo completar la suscripción.',
            ], 500);

        } catch (\Exception $e) {
            Log::error('Error al suscribirse a ' . $listName . ': ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error. Por favor intenta más tarde.',
            ], 500);
        }
    }

}