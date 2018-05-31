$(document).ready(function () {
    $(document).on('submit', '#properties-form', function (e) {
        e.preventDefault();

        var sort_order = [];

        $('.sort_ul ul li img').each(function () {
            sort_order.push($(this).data('id'));
        });

        $.ajax({
            url: $('.url_handler').data('url'),
            type: "POST",
            data: {
                sort_order: sort_order,
                form_data: $("#properties-form").serialize(),
                product_id: $('.product_id').data('id')
            },
            success: function (response) {
                $(location).attr("href", response.url);
            },
            error: function () {
                alert('Error');
            }
        });
    })
});