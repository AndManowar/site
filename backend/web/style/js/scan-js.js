/**
 * Created by User on 27.04.2016.
 */



$(function() {

    $(document).on('click', '#scan-new-rout-table tr .item-save-btn', function(e){
        e.preventDefault();

        var line = $(this).closest('tr');
        var routName = $(line).attr('data-rout-name');
        var groupName = $(line).find('select').val();
        var branchId = $('#scan-new-rout-table').attr('data-branch-id');

        $.ajax({
            type: 'post',
            url: 'add-rout',
            data: {
                rout: routName,
                group: groupName,
                branch: branchId,
                _csrf: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(data){
                if(data == true || data == 'true') {
                    $(line).remove();
                }else{
                    alert('Error operation');
                }
            }
        });


    });

    $(document).on('change', '#access-permission-change-tbl .access-permission-change-checkbox', function(e){
        var status = 100;
        var td = $(this).closest('td');
        var group = $(this).closest('tr').attr('data-group');
        var role = $(td).attr('data-role');

        if($(this).is(":checked")) {
            status = 1;
        }else{
            status = 0;
        }

        $.ajax({
            type: 'post',
            url: '/dashboard/roles/update',
            data: {
                role: role,
                group: group,
                status: status,
                _csrf: $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(data){
                if(data == true || data == 'true') {

                }else{
                    alert('Error operation');
                }
            }
        });
    });




});


