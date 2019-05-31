$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    // edit category
    $('.editCat').click(function () {
        $('.error').hide();
        let id = $(this).data('id');
        // alert(id);
        //  hiện dữ liệu ra modal
        $.ajax({
            url: 'admin/category/' + id + '/edit',
            dataType: 'json',
            type: 'get',
            success: function ($result) {
                // console.log($result) trả về 1 object sản phẩm trong db
                //    đổ giá trị ra input modal
                $('.name').val($result.name);
                $('.title').text($result.name);
                if ($result.status === 1) {
                    // thêm attribute selected vào
                    $('.show').attr('selected', 'selected');
                } else {
                    $('.hidden').attr('selected', 'selected');
                }
            }
        });

        $('.updateCat').click(function () {
            let name = $('.name').val();
            let status = $('.status').val();
            $.ajax({
                url: 'admin/category/' + id,
                type: 'put',
                dataType: 'json',
                data: {
                    name: name,
                    status: status
                },
                success: function ($result) {
                    // console.log($result), có lỗi thì hiện ra
                    if ($result.error === 'true') {
                        let errorSelector = $('.error');
                        errorSelector.show();
                        errorSelector.text($result.message.name[0]);
                    } else {
                        // $result.success là response()->json(['success' bên controller
                        toastr.success($result.success, 'Thông báo', {timeOut: 5000});
                        $('#edit').modal('hide');
                        location.reload();
                    }
                }
            });
        });

    });
    // delete category
    $('.deleteCat').click(function () {
       let id = $(this).data('id');
        // nếu nhấn có thì xóa, ngược lại cancel
        $('.confirmDel').click(function () {
            $.ajax({
               url: 'admin/category/' + id,
                type:'delete',
                dataType: 'json',
                success: function ($result) {
                    // $result.success là response()->json(['success' bên controller
                    toastr.success($result.success, 'Thông báo', {timeOut: 5000});
                    $('#edit').modal('hide');
                    location.reload();
                }
            });
        });
    });
});
