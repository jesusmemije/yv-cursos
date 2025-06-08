/**

Maneja el cambio al mes anterior en el calendario.
*/
$(document).on('click', '#prevMonth', function () {
    changeMonth(-1);
});

/**

Maneja el cambio al mes siguiente en el calendario.
*/
$(document).on('click', '#nextMonth', function () {
    changeMonth(1);
});

/**

Cambia el mes del calendario y actualiza su contenido mediante AJAX.

@param {number} diff - Diferencia de mes a aplicar (-1 para anterior, 1 para siguiente).
*/
function changeMonth(diff) {
    let month = parseInt($('#calendario').data('month'));
    let year = parseInt($('#calendario').data('year'));

    month += diff;
    if (month < 1) {
        month = 12;
        year--;
    } else if (month > 12) {
        month = 1;
        year++;
    }

    $.ajax({
        url: '?month=' + month + '&year=' + year,
        success: function (data) {
            $('#calendarContainer').html(data);
        }
    });
}

/**

Muestra un modal con los eventos del día seleccionado.
*/
$(document).on('click', 'td[data-date]', function () {
    let date = $(this).data('date');
    $.get('/search-events-by-date?date=' + date, function (html) {
        $('#eventModal .modal-body').html(html);
        $('#eventModal').modal('show');
    });
});