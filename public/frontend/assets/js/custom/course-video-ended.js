(function ($) {
    "use strict";
    var isCompletingLecture = false;

    //Normal Video
    $('.myVideo').on('ended', function (){
        callCompleteCourse();
    });

    // Vimeo video
    $(document).ready(function(){

        var vimeoVideoSource = $('.vimeoVideoSource').val();
        if (vimeoVideoSource) {
            var iframe = $('#playerVideoVimeo iframe');
            var player = new Vimeo.Player(iframe);

            player.on('ended', function() {
                callCompleteCourse();
            });
        }

    });

    window.__setCompletingLecture = function (state) {
        isCompletingLecture = !!state;
    };

    window.__isCompletingLecture = function () {
        return isCompletingLecture;
    };

})(jQuery);

function navigateToNextLectureOrReload() {
    if (typeof showCourseLoader === 'function') {
        showCourseLoader();
    }
    var nextUrl = (typeof nextLectureRoute === 'string') ? nextLectureRoute.trim() : '';
    if (nextUrl.length > 0) {
        setTimeout(function () {
            window.location.assign(nextUrl);
        }, 120);
        return;
    }
    setTimeout(function () {
        window.location.reload();
    }, 120);
}

function callCompleteCourse(){
    if (typeof window.__isCompletingLecture === 'function' && window.__isCompletingLecture()) {
        return;
    }
    if (typeof window.__setCompletingLecture === 'function') {
        window.__setCompletingLecture(true);
    }
    if (typeof showCourseLoader === 'function') {
        showCourseLoader();
    }

    $.ajax({
        type: "GET",
        url: videoCompletedRoute,
        data: {'course_id': course_id, 'lecture_id': lecture_id,  'enrollment_id': enrollment_id},
        dataType: "json",
        success: function (response) {
            if(typeof response.data !== 'undefined' && response.data !== null && typeof response.data.html !== 'undefined' && response.data.html !== null ){
                $('#demo-certificate').html(response.data.html).promise().then(function(){
                    saveToServer(response.data.certificate_number);
                });
            }
            else{
                navigateToNextLectureOrReload();
            }
        },
        error: function () {
            if (typeof window.__setCompletingLecture === 'function') {
                window.__setCompletingLecture(false);
            }
            if (typeof hideCourseLoader === 'function') {
                hideCourseLoader();
            }
            toastr.options.positionClass = 'toast-bottom-right';
            toastr.error('No se pudo actualizar el avance. Intenta de nuevo.');
        },
    });
}

function saveToServer(certificate_number){
    if (typeof showCourseLoader === 'function') {
        showCourseLoader();
    }
    html2canvas(document.getElementById("certificate-preview-div-hidden")).then(function(canvas){
        var dataURL = canvas.toDataURL();
        $.ajax({
            type: "POST",
            url: certificateSaveRoute,
            data: {'certificate_number' : certificate_number, 'course_id': course_id, 'lecture_id': lecture_id,  'enrollment_id': enrollment_id, 'file': dataURL , '_token': $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                if(response.status == 200){
                    if (typeof showCourseLoader === 'function') {
                        showCourseLoader();
                    }
                    setTimeout(function () {
                        window.location.reload();
                    }, 120);
                    return;
                }
                if (typeof window.__setCompletingLecture === 'function') {
                    window.__setCompletingLecture(false);
                }
                if (typeof hideCourseLoader === 'function') {
                    hideCourseLoader();
                }
            },
            error: function () {
                if (typeof window.__setCompletingLecture === 'function') {
                    window.__setCompletingLecture(false);
                }
                if (typeof hideCourseLoader === 'function') {
                    hideCourseLoader();
                }
                toastr.options.positionClass = 'toast-bottom-right';
                toastr.error('No se pudo guardar el certificado. Intenta de nuevo.');
            }
        });
    }).catch(function() {
        if (typeof window.__setCompletingLecture === 'function') {
            window.__setCompletingLecture(false);
        }
        if (typeof hideCourseLoader === 'function') {
            hideCourseLoader();
        }
        toastr.options.positionClass = 'toast-bottom-right';
        toastr.error('No se pudo generar el certificado. Intenta de nuevo.');
    });
}
