jQuery(document).ready(function ($) {

    $(document).on('click', '.categoryBtn',function () {
        let category = $(this).data('slug');
        $('.loading-container').show();
        $('.categoryBtn').removeClass('selected');
        $(this).addClass('selected');

        $.ajax({
            type: 'POST',
            url: coursesObj.rest_url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', coursesObj.nonce);
            },
            data: { 'category': category },
            success: function (response) {
                $('.courses-posts').html('');
                $('.courses-posts').html(response);
                $('.loading-container').hide();
            },
            error: function () {}
        });
    });

});