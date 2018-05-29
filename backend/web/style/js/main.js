$(document).ready(function () {

    $(document).on('click', '.add_field', function (e) {
        e.preventDefault();

        var button = $(this);

        if (parseInt(button.attr('data-state')) === 1) {
            $('.additional_fields').removeClass('hidden');
            button.attr('data-state', 2);
        } else {
            $('.additional_fields').addClass('hidden');
            button.attr('data-state', 1);
        }
    });

    // DO NOT REMOVE : GLOBAL FUNCTIONS!
    pageSetUp();

    /*
     * PAGE RELATED SCRIPTS
     */

    $(".js-status-update a").click(function () {
        var selText = $(this).text();
        var $this = $(this);
        $this.parents('.btn-group').find('.dropdown-toggle').html(selText + ' <span class="caret"></span>');
        $this.parents('.dropdown-menu').find('li').removeClass('active');
        $this.parent().addClass('active');
    });

    function reloadTaskPjax() {
        $.pjax.reload({
            container: "#tasks_pjax",
            timeout: false
        }).done(function () {
            initSortable();
        });
    }

    /*
    * TODO: add a way to add more todo's to list
    */

    // initialize sortable
    function initSortable() {
        $("#sortable1, #sortable2, #sortable3").sortable({
            handle: '.handle',
            connectWith: ".todo",
            receive: function (event, ui) {

                var status = event.target.getAttribute('data-status'),
                    id = 0,
                    arrayLi = [],
                    ul_id = '#' + event.target.getAttribute('id');

                $(ul_id + ' > li').each(function () {
                    arrayLi.push($(this).find('input[type="checkbox"]').data('id'));
                });

                $.each(ui.item, function () {
                    id = $(this).find('input[type="checkbox"]').data('id');
                });

                $.ajax({
                    url: '/dashboard/ajax/change-task-status',
                    type: 'POST',
                    data: {id: id, status: status, order: arrayLi},
                    success: function () {
                        reloadTaskPjax();
                    }
                });
            },
            stop: function (event) {

                var arrayLi = [],
                    ul_id = '#' + event.target.getAttribute('id');

                $(ul_id + ' > li').each(function () {
                    arrayLi.push($(this).find('input[type="checkbox"]').data('id'));
                });

                $.ajax({
                    url: '/dashboard/ajax/change-tasks-order',
                    type: 'POST',
                    data: {order: arrayLi},
                    success: function () {
                        reloadTaskPjax();
                    }
                });

            }
        })
    }

    var new_task_block = $('.new_task_block');

    initSortable();

    // check and uncheck
    $(document).on('click', '.todo .checkbox > input[type="checkbox"]', function () {
        var $this = $(this).parent().parent().parent();

        if ($(this).prop('checked')) {

            $.ajax({
                url: '/dashboard/ajax/complete-task',
                type: 'POST',
                data: {id: $(this).data('id')},
                success: function () {
                    $this.addClass("complete");

                    $(this).parent().hide();

                    $this.slideUp(500, function () {
                        $this.clone().prependTo("#sortable5").effect("highlight", {}, 800);
                        $this.remove();
                        reloadTaskPjax();
                    });
                }
            });


        } else {
            $.ajax({
                url: '/dashboard/ajax/revert-task',
                type: 'POST',
                data: {id: $(this).data('id')},
                success: function (data) {
                    $this.removeClass("complete");

                    $(this).parent().hide();

                    $this.slideUp(500, function () {
                        $this.clone().prependTo("#sortable" + data.sortable).effect("highlight", {}, 800);
                        $this.remove();
                        reloadTaskPjax();
                    });
                }
            });
        }


    });

    // Сабмит формы с задачами
    $('body').on('beforeSubmit', 'form#new_task_form', function () {
        var form = $(this);
        // return false if form still have some validation errors
        if (form.find('.has-error').length) {
            return false;
        }
        // submit form
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function () {
                new_task_block.empty();
                reloadTaskPjax();
            },
            error: function () {
                alert('error');
            }
        });
        return false;
    });


    // Добавление новой задачи
    $(document).on('click', '.add_new_task', function () {
        $.ajax({
            url: '/dashboard/ajax/create-task',
            type: 'GET',
            success: function (data) {
                new_task_block.html(data);
            }
        });
    });

    // Обновление задачи
    $(document).on('click', '.update_task', function () {
        $.ajax({
            url: '/dashboard/ajax/update-task',
            type: 'POST',
            data: {id: $(this).parent().parent().find('input[type="checkbox"]').data('id')},
            success: function (data) {
                new_task_block.html(data);
            }
        });
    });

    // Удаление завершенных задач
    $(document).on('click', '.remove_complete_tasks', function () {
        $.ajax({
            url: '/dashboard/ajax/remove-done-tasks',
            type: 'GET',
            success: function () {
                reloadTaskPjax();
            }
        });
    });

    // Прячем форму создание задачи
    $(document).on('click', '.remove_task_block', function () {
        new_task_block.empty();
    });
});