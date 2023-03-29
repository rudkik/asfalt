/* global $ */

$(function() {
    'use strict';


    function _initDelete() {
        $('[data-type="DELETE"]:not([data-delete-fileupload="1"]), [data-type="CANCEL"]:not([data-delete-fileupload="1"])').click(function () {
            var url = $(this).data('url');
            var type = $(this).data('type');
            $(this).parents('li').remove();

            if(type != 'CANCEL') {
                jQuery.ajax({
                    url: url,
                    data: ({}),
                    type: type,
                    success: function (data) {
                    },
                    error: function (data) {
                        console.log(data.responseText);
                    }
                });
            }
        }).attr('data-delete-fileupload', 1);
    }

    // Initialize the jQuery File Upload widget:
    $('#fileupload').fileupload({
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: '/calendar/file/load_files'
    });

    // Enable iframe cross-domain access via redirect option:
    $('#fileupload').fileupload(
        'option',
        'redirect',
        window.location.href.replace(/\/[^/]*$/, '/cors/result.html?%s')
    );
    $('#fileupload').bind('fileuploadfinished', function(e, data) {
        var activeUploads = $('#fileupload').fileupload('active');
        if(activeUploads == 1) {
            _initDelete();
        }
    });
    // загрузку предварительно загруженных файлов
    if(false) {
        // Load existing files:
        $('#fileupload').addClass('fileupload-processing');
        $.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this)
                .fileupload('option', 'done')
                // eslint-disable-next-line new-cap
                .call(this, $.Event('done'), {result: result});

            _initDelete();
        });
    }
    _initDelete();
});
