$(document).ready(function () {
    $(document).on('click', '.edit_color', function (e) {
        e.preventDefault();
        var button = $(this);
        $.ajax({
            url: button.data('url'),
            type: "POST",
            data: {id: button.data('id')},
            success: function (response) {
                if (button.closest('tr').find('.hidden_form').hasClass('hidden')) {
                    button.closest('tr').find('.hidden_form').removeClass('hidden').html(response);
                }else{
                    button.closest('tr').find('.hidden_form').addClass('hidden').html(response);
                }
            },
            error: function () {
            }
        });
    });

    $(document).on('click', '.delete_image_button', function (e) {
        e.preventDefault();
        var button = $(this);
        $.ajax({
            url: '/dashboard/ajax/delete-image',
            type: "POST",
            data: {id: button.data('id')},
            success: function () {
                button.closest('li').remove();
            },
            error: function () {
            }
        });
    });
});