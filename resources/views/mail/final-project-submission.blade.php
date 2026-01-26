{{-- filepath: resources/views/mail/final-project-submission.blade.php --}}
@component('mail::message')
# Nuevo Trabajo Final Recibido

Hola **{{ $instructor_name }}**,

El estudiante **{{ $student_name }}** ha enviado su trabajo final para el curso **{{ $course_name }}** en el ciclo escolar **{{ $cycle_name }}**.

## Detalles del Envío

| Campo | Valor |
|-------|-------|
| **Estudiante** | {{ $student_name }} |
| **Email** | {{ $student_email }} |
| **Curso** | {{ $course_name }} |
| **Ciclo Escolar** | {{ $cycle_name }} |
| **Título del Trabajo** | {{ $project_title }} |
| **Fecha de Envío** | {{ $submitted_date }} |

## Descripción del Trabajo

{{ $project_description }}

---

**Archivo Adjunto:** {{ $file_name }}

Por favor revisa el trabajo y proporciona retroalimentación al estudiante a través de correo electrónico.

Saludos cordiales,  
{{ config('app.name') }}
@endcomponent