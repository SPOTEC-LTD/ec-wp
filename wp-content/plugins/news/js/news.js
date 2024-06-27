jQuery(document).ready(function ($) {

    $(document).on('click', '#more-btn',function () {
        let count = $(this).data('count');
        $('.loading-container').show();

        $.ajax({
            type: 'POST',
            url: newsObj.rest_url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', newsObj.nonce);
            },
            data: { 'count': count },
            success: function (response) {
                $('.show-more-news').html('');
                $('.show-more-news').html(response);
                $('.loading-container').hide();
            },
            error: function () {}
        });
    });

    $(document).on('click', '#more-ann-btn',function () {
        let count = $(this).data('count');
        $('.loading-container').show();

        $.ajax({
            type: 'POST',
            url: newsObj.rest_url_2,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', newsObj.nonce);
            },
            data: { 'count': count },
            success: function (response) {
                $('.show-more-announcements').html('');
                $('.show-more-announcements').html(response);
                $('.loading-container').hide();
            },
            error: function () {}
        });
    });

});