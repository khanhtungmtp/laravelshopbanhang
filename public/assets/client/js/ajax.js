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
                if (data.error) {
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

    // add address checkout
    let errorEmailSelector = $('.errorEmail');
    let errorAddressSelector = $('.errorAddress');
    let errorPhoneSelector = $('.errorPhone');
    errorEmailSelector.hide();
    errorAddressSelector.hide();
    errorPhoneSelector.hide();
    $('.addAdress').click(function () {
        let active = '';
        let email = $('.email').val();
        let phone = $('.phone').val();
        let address = $('.address').val();
        if ($('.actives').prop('checked')) {
            active = 1
        } else {
            active = 0
        }
        $.ajax({
            url: 'customer',
            type: 'post',
            data: {
                email: email,
                phone: phone,
                address: address,
                active: active
            },
            dataType: 'json',
            success: function (data) {
                console.log(data)
                $('#address').modal('hide');
                toastr.success(data, 'Thông báo', {timeOut: 5000});
                location.reload()
            },
            error: function (data) {
                // console.log(data)
                let error = $.parseJSON(data.responseText);
                if (typeof error.errors.email != 'undefined' && error.errors.email.length > 0) {
                    errorEmailSelector.show();
                    errorEmailSelector.html(error.errors.email)
                }
                if (typeof error.errors.phone != 'undefined' && error.errors.phone.length > 0) {
                    errorPhoneSelector.show();
                    errorPhoneSelector.html(error.errors.phone)
                }
                if (typeof error.errors.address != 'undefined' && error.errors.address.length > 0) {
                    errorAddressSelector.show();
                    errorAddressSelector.html(error.errors.address)
                }
            }
        });
    });

    // thanh toan
    $('.payment').click(function () {
        let email = '';
        let address = '';
        let name = '';
        let phone = '';
        let note = $('.note').val();
        let paytotal = $('.paytotal').text();
        paytotal = paytotal.replace(' VNĐ', '');
        let radioAddress = $('input[name=rdoaddress]');
        
        $.each(radioAddress, function (key, value) {
            if (value.checked == true) {
                email = value.value;
                name = $('.name' + key).text();
                address = $('.address' + key).text();
                phone = $('.phone' + key).text();
            }
        });
        $.ajax({
            url: 'cart',
            type: 'post',
            dataType: 'json',
            data: {
                email: email,
                name: name,
                phone: phone,
                address: address,
                message: note,
                money: paytotal
            },
            success: function (data) {
                toastr.success(data, 'Thông báo', {timeOut: 5000});
                location.href = '/';
            }
        });
    });

});
