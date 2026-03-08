(function () {
    'use strict';

    var lectureTypeValue = $('.lecture_type').val();
    var openGalleryModalOnChange = false;

    $('.add-more-section-btn').on('click', function () {
        $('.add-more-section-wrap').removeClass('d-none');
        $('.add-more-lesson-box').addClass('d-none');
    });

    $('.cancel-add-more-section').on('click', function () {
        $('.add-more-section-wrap').addClass('d-none');
        $('.add-more-lesson-box').removeClass('d-none');
    });

    $('.lecture-type').on('click', function () {
        lectureType($(this).val());
    });

    $(document).on('change', '.video-source-type', function () {
        openGalleryModalOnChange = true;
        toggleVideoSourceFields();
    });

    $(document).on('click', '.open-video-gallery-modal', function (event) {
        event.preventDefault();
        openVideoGalleryModal();
    });

    $(document).on('click', '.select-gallery-video', function (event) {
        event.preventDefault();

        var videoId = String($(this).data('videoId') || '');
        var videoTitle = String($(this).data('videoTitle') || '');
        setSelectedGalleryVideo(videoId, videoTitle);
        toggleVideoGalleryModal('hide');
    });

    $(document).on('click', '.clear-gallery-video-selection', function (event) {
        event.preventDefault();
        setSelectedGalleryVideo('', '');
    });

    $('.vimeo_upload_type').change(function () {
        var vimeoUploadType = $(this).val();
        if (vimeoUploadType === '1') {
            $('.vimeo_Video_file_upload_div').removeClass('d-none');
            $('.vimeo_uploaded_Video_id_div').addClass('d-none');
            $('#vimeo_url_path').attr('required', true);
            $('#vimeo_url_uploaded_path').removeAttr('required');
            $('.customVimeoFileDuration').removeAttr('required');
        } else if (vimeoUploadType === '2') {
            $('.vimeo_uploaded_Video_id_div').removeClass('d-none');
            $('.vimeo_Video_file_upload_div').addClass('d-none');
            $('#vimeo_url_path').removeAttr('required');
            $('#vimeo_url_uploaded_path').attr('required', true);
            $('.customVimeoFileDuration').attr('required', true);
        }
    });

    function lectureType(type) {
        if (type === 'video') {
            $('#video').removeClass('d-none');
            $('#youtube').addClass('d-none');
            $('#vimeo').addClass('d-none');
            $('#text').addClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').addClass('d-none');

            $('#fileDuration').addClass('d-none');
            $('.customFileDuration').removeAttr('required');
            $('#youtube_url_path').removeAttr('required');

            resetVimeoRequired();
            clearNonVideoRequired();
            toggleVideoSourceFields();
            return;
        }

        $('#video').addClass('d-none');
        $('#video_file').removeAttr('required');
        $('#video_title').removeAttr('required');
        $('#video_gallery_id').removeAttr('required');

        if (type === 'youtube') {
            $('#youtube').removeClass('d-none');
            $('#vimeo').addClass('d-none');
            $('#text').addClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').addClass('d-none');

            $('#fileDuration').removeClass('d-none');
            $('.customFileDuration').attr('required', true);
            $('#youtube_url_path').attr('required', true);

            resetVimeoRequired();
            clearNonVideoRequired();
            return;
        }

        $('#youtube').addClass('d-none');
        $('#youtube_url_path').removeAttr('required');
        $('#fileDuration').addClass('d-none');
        $('.customFileDuration').removeAttr('required');

        if (type === 'vimeo') {
            $('#vimeo').removeClass('d-none');
            $('#text').addClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').addClass('d-none');

            $('#vimeo_upload_type').attr('required', true);
            clearNonVideoRequired();
            return;
        }

        $('#vimeo').addClass('d-none');
        resetVimeoRequired();

        if (type === 'text') {
            $('#text').removeClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').addClass('d-none');
            clearNonVideoRequired();
            return;
        }

        if (type === 'image') {
            $('#text').addClass('d-none');
            $('#imageDiv').removeClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').addClass('d-none');
            clearNonVideoRequired();
            $('#image').attr('required', true);
            return;
        }

        if (type === 'pdf') {
            $('#text').addClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').removeClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').addClass('d-none');
            clearNonVideoRequired();
            $('#pdf').attr('required', true);
            return;
        }

        if (type === 'slide_document') {
            $('#text').addClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').removeClass('d-none');
            $('#audioDiv').addClass('d-none');
            clearNonVideoRequired();
            $('#slide_document').attr('required', true);
            return;
        }

        if (type === 'audio') {
            $('#text').addClass('d-none');
            $('#imageDiv').addClass('d-none');
            $('#pdfDiv').addClass('d-none');
            $('#slide_documentDiv').addClass('d-none');
            $('#audioDiv').removeClass('d-none');
            clearNonVideoRequired();
            $('#audio').attr('required', true);
        }
    }

    function toggleVideoSourceFields() {
        if (!$('input[name="video_source"]').length) {
            return;
        }

        var source = $('input[name="video_source"]:checked').val() || 'upload';
        if (source === 'gallery') {
            $('#videoUploadFields').addClass('d-none');
            $('#videoGalleryFields').removeClass('d-none');
            $('#video_gallery_id').attr('required', true);
            $('#video_file').removeAttr('required');
            $('#video_title').removeAttr('required');

            if (openGalleryModalOnChange) {
                openVideoGalleryModal();
            }
        } else {
            $('#videoUploadFields').removeClass('d-none');
            $('#videoGalleryFields').addClass('d-none');
            $('#video_gallery_id').removeAttr('required');

            if ($('#video_file').data('requireWhenVideo')) {
                $('#video_file').attr('required', true);
            }
            if ($('#video_title').data('requireWhenVideo')) {
                $('#video_title').attr('required', true);
            }
        }

        openGalleryModalOnChange = false;
        syncSelectedGalleryVideoLabel();
    }

    function openVideoGalleryModal() {
        if ($('#videoGalleryModal').length) {
            toggleVideoGalleryModal('show');
            return;
        }

        if ($('#video_gallery_id').is('select')) {
            $('#video_gallery_id').focus();
        }
    }

    function toggleVideoGalleryModal(action) {
        var modalElement = document.getElementById('videoGalleryModal');
        if (!modalElement) {
            return;
        }

        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
            if (action === 'show') {
                modalInstance.show();
            } else {
                modalInstance.hide();
            }
            return;
        }

        $('#videoGalleryModal').modal(action);
    }

    function setSelectedGalleryVideo(videoId, videoTitle) {
        var galleryInput = $('#video_gallery_id');
        if (!galleryInput.length) {
            return;
        }

        galleryInput.val(videoId).trigger('change');
        syncSelectedGalleryVideoLabel(videoTitle);
    }

    function syncSelectedGalleryVideoLabel(forcedTitle) {
        var selectedTitleField = $('#selected_video_title');
        if (!selectedTitleField.length) {
            return;
        }

        var galleryInput = $('#video_gallery_id');
        var selectedId = String(galleryInput.val() || '');

        if (!selectedId) {
            selectedTitleField.val('');
            return;
        }

        var selectedTitle = forcedTitle || '';
        if (!selectedTitle && galleryInput.is('select')) {
            selectedTitle = galleryInput.find('option:selected').text();
        }

        if (!selectedTitle) {
            var trigger = $('.select-gallery-video[data-video-id="' + selectedId + '"]').first();
            selectedTitle = String(trigger.data('videoTitle') || '');
        }

        selectedTitleField.val(selectedTitle);
    }

    function resetVimeoRequired() {
        $('#vimeo_upload_type').removeAttr('required');
        $('#vimeo_url_path').removeAttr('required');
        $('#vimeo_url_uploaded_path').removeAttr('required');
        $('.customVimeoFileDuration').removeAttr('required');
    }

    function clearNonVideoRequired() {
        $('.textDescription').removeAttr('required');
        $('#image').removeAttr('required');
        $('#pdf').removeAttr('required');
        $('#slide_document').removeAttr('required');
        $('#audio').removeAttr('required');
    }

    /*** =========== Youtube validation check ===============**/
    $(function () {
        var oldType = $('.oldTypeYoutube').val();
        var typeFromRadio = $('input[name="type"]:checked').val();
        var initialType = oldType || typeFromRadio || lectureTypeValue || 'video';
        lectureType(initialType);

        if (initialType === 'youtube') {
            $('#lectureTypeYoutube').attr('checked', true);
        }

        syncSelectedGalleryVideoLabel();
    });

    $(document).on('change', '#video_gallery_id', function () {
        syncSelectedGalleryVideoLabel();
    });

    /*** =========== media duration ===============**/
    function attachMediaDurationListener(inputId) {
        var input = document.getElementById(inputId);
        if (!input) {
            return;
        }

        input.onchange = function () {
            if (!this.files || !this.files.length) {
                return;
            }

            var file = this.files[0];
            var media = document.createElement('video');
            media.preload = 'metadata';
            media.onloadedmetadata = function () {
                window.URL.revokeObjectURL(media.src);
                var duration = media.duration || 0;
                $('#file_duration').val(duration);
            };
            media.src = URL.createObjectURL(file);
        };
    }

    window.URL = window.URL || window.webkitURL;
    attachMediaDurationListener('video_file');
    attachMediaDurationListener('vimeo_url_path');
    attachMediaDurationListener('audio');
})();
