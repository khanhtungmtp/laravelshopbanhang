$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function () {
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
    })
});
