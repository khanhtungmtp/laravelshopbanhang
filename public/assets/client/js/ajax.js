$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
    // update quantity
    $('.qty').blur(function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'cart/' + id,
            type: 'put',
            dataType: 'json',
            data: {
                qty: $(this).val()
            },
            success: function (data) {
                // console.log(data)
                if (data.error){
                    toastr.success(data.error, 'Thông báo', {timeOut: 5000});
                } else {
                    toastr.success(data.message, 'Thông báo', {timeOut: 5000});
                    location.reload();
                }
            }
        })
    });
    // delete cart
    $('.close1').click(function () {
        $('#deleteCart').modal('show');
        let id = $(this).data('id');
        $('.confirmDelCart').click(function () {
            $.ajax({
                url: 'cart/' + id,
                type: 'delete',
                dataType: 'json',
                success: function (data) {
                    $('#deleteCart').modal('hide');
                    toastr.success(data.message, 'Thông báo', {timeOut: 5000});
                    location.reload();
                }
            })
        })
    });
});
