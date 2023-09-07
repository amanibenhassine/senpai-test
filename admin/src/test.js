
jQuery(document).ready(function($) {
    $('#custom-form').submit(function(e) {
        e.preventDefault();

        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: senpai_test_ajax_params.ajaxurl,
            data: {
                action: 'process_form_data',
                form_data: formData
            },
            success: function(response) {
                console.log(response);
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error('AJAX request failed: ' + errorThrown);
            }
        });
    });
});

