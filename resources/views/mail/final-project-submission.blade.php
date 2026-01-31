@component('mail::message')
# Nuevo Trabajo Final Recibido

Hola **{{ $mailData['instructor_name'] }}**,

El estudiante **{{ $mailData['student_name'] }}** ha enviado su trabajo final para el curso **{{ $mailData['course_name'] }}** en el ciclo escolar **{{ $mailData['cycle_name'] }}**.

@component('mail::panel')
## Detalles del Envío
**Título del Trabajo:** {{ $mailData['project_title'] }}  
**Fecha de Envío:** {{ $mailData['submitted_date'] }}  
**Email del Estudiante:** {{ $mailData['student_email'] }}
@endcomponent

### Descripción del Trabajo
{{ $mailData['project_description'] }}

---

**Archivo Adjunto:** {{ $mailData['file_name'] }}

Por favor, revisa el trabajo y proporciona la retroalimentación correspondiente.

Saludos cordiales,  
**{{ config('app.name') }}**
@endcomponent