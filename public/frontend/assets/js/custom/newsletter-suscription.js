// Llamadas para cada formulario
handleSubscribeForm('#coursesForm', '.routeSubscribeCourses');
handleSubscribeForm('#postsForm', '.routeSubscribePosts');

/**
 * Envía un formulario de suscripción por AJAX a nuestra API en NewsletterController y muestra notificaciones (error, success) con Toastr.
 * 
 * @param {string} formSelector - Selector del formulario a enviar.
 * @param {string} routeSelector - Selector del input/elemento con la URL destino.
 */
function handleSubscribeForm(formSelector, routeSelector) {
    $(formSelector).on('submit', function (e) {
        e.preventDefault();

        toastr.options.positionClass = 'toast-bottom-right';

        var route = $(routeSelector).val();

        $.ajax({
            url: route,
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function (response) {
                if (response.success) {
                    $(formSelector).trigger("reset");
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr) {
                let msg = "Ocurrió un error. Por favor intente más tarde.";
                if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
            }
        });
    });
}