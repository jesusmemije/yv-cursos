(function ($) {
    "use strict";

    // Manejador para cursos normales (no diplomados)
    $(document).on('click', '.addToCart', function (e) {
        // Verificar que NO sea un diplomado (que no tenga #groupSelect)
        const groupSelect = $('#groupSelect');
        if (groupSelect.length > 0) {
            // Es un diplomado, el manejador personalizado se encargará
            return;
        }

        e.preventDefault();

        var course_id = $(this).data('course_id');
        var product_id = $(this).data('product_id');
        var bundle_id = $(this).data('bundle_id');
        var quantity = $(this).data('quantity');
        var route = $(this).data('route');
        var ref = localStorage.getItem('ref')

        $.ajax({
            type: "POST",
            url: route,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'course_id': course_id,
                'product_id': product_id,
                'bundle_id': bundle_id,
                'ref': ref,
                'quantity': quantity
            },
            datatype: "json",
            success: function (response) {
                handleAddToCartResponse(response);
            },
            error: function (error) {
                toastr.options.positionClass = 'toast-bottom-right';
                if (error.status == 401){
                    window.location.href = '/login';
                }
                if (error.status == 403){
                    toastr.error("¡No tienes permiso para agregar curso o producto!")
                }
            },
        });
    })

    // Para diplomados: Manejar el click en "Agregar al carrito"
    window.handleAddToCartDiploma = function(event, courseId, route, groupId = null) {
        event.preventDefault();
        
        // Si no se proporciona groupId, obtenerlo del select o del input hidden
        if (!groupId) {
            const groupSelect = document.getElementById('groupSelect');
            groupId = groupSelect ? groupSelect.value : null;
        }
        
        // Validar que se haya seleccionado un grupo
        if (!groupId) {
            toastr.warning("Por favor selecciona un grupo");
            return false;
        }

        // Si la validación pasó, hacer la petición AJAX
        $.ajax({
            url: route,
            type: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'course_id': courseId,
                'group_id': groupId
            },
            success: function(response) {
                handleAddToCartResponse(response);
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '/login';
                } else {
                    toastr.error("Error");
                }
            }
        });
    };

    // Manejar respuesta de agregar al carrito
    function handleAddToCartResponse(response) {
        toastr.options.positionClass = 'toast-bottom-right';
        if (response.status == 402) {
            toastr.error(response.msg)
        }
        if (response.status == 401 || response.status == 404 || response.status == 409){
            toastr.error(response.msg)
        } else if(response.status == 200) {
            $('.cartQuantity').text(response.quantity)
            toastr.success(response.msg)
            $('.msgInfoChange').html(response.msgInfoChange)
        } else if(response.status == 422) {
            toastr.error(response.msg)
        }
    }

})(jQuery);
