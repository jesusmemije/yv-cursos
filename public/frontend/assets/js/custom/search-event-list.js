(function () {
  'use strict'
  $(document).on('keyup', '.searchEvent', function() {
      var title = $(this).val();
      var searchEventRoute = $('.searchEventRoute').val();

      if (title) {
          $('.searchEventBox').removeClass('d-none');
          $('.searchEventBox').addClass('d-block');
      } else {
          $('.searchEventBox').removeClass('d-block');
          $('.searchEventBox').addClass('d-none');
      }

      $.ajax({
          type: "GET",
          url: searchEventRoute,
          data: {'title': title},
          success: function (response) {
              $('.appendEventSearchList').html(response);
          }
      });
  });
})()
