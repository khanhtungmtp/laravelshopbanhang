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
                    // console.log($result)
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
                type: 'delete',
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

    // edit Product type
    $('.editProductType').click(function () {
        let errorSelector = $('.error');
        errorSelector.hide();
        let id = $(this).data('id');
        // alert(id)
        $.ajax({
            url: ' admin/product-type/' + id + '/edit',
            type: 'get',
            dataType: 'json',
            success: function ($data) {
                // console.log($data)
                let name = $('.name').val($data.producttype.name);
                let status = $('.status').val($data.producttype.status);
                let idCategorySelector = $('.idCategory');
                let idCategory = idCategorySelector.val($data.producttype.idCategory);
                if (status === 1) {
                    // thêm attribute selected vào
                    $('.show').attr('selected', 'selected');
                } else {
                    $('.hidden').attr('selected', 'selected');
                }
                let html = '';
                // lặp data
                $.each($data.category, function ($key, $value) {
                    // console.log($value['id'] === $data.producttype.idCategory)
                    if ($value['id'] === $data.producttype.idCategory) {
                        html += '<option value=' + $value['id'] + ' selected>';
                        html += $value['name'];
                        html += '</option>'
                    } else {
                        html += '<option value=' + $value['id'] + '>';
                        html += $value['name'];
                        html += '</option>'
                    }
                });
                // đổ thẻ option ra
                idCategorySelector.html(html);
            }
        });

        // khi nhấn cập nhập
        $('.updateProductType').click(function () {
            let idCategory = $('.idCategory').val();
            let name = $('.name').val();
            let status = $('.status').val();
            $.ajax({
                url: 'admin/product-type/' + id,
                type: 'put',
                dataType: 'json',
                data: {
                    idCategory: idCategory,
                    name: name,
                    status: status
                },
                success: function ($result) {
                    if ($result.error === 'true') {
                        errorSelector.show();
                        errorSelector.text($result.message.name[0]);
                    } else {
                        // $result.success là response()->json(['success' bên controller
                        toastr.success($result.success, 'Thông báo', {timeOut: 5000});
                        $('#updateProductType').modal('hide');
                        location.reload();
                    }
                }
            });
        });
    });

    // delete product type
    $('.deleteProductType').click(function () {
        let id = $(this).data('id');
        // nếu click vào có, thì xóa
        $('.confirmDelProType').click(function () {
            $.ajax({
                url: 'admin/product-type/' + id,
                type: 'delete',
                dataType: 'json',
                success: function ($result) {
                    // $result.success là response()->json(['success' bên controller
                    toastr.success($result.message, 'Thông báo', {timeOut: 5000});
                    $('#editProductType').modal('hide');
                    location.reload();
                }
            });
        })

    });

    // ajax lấy loại sản phẩm tương ứng category
    $('.cateProduct').change(function () {
        let idCateProduct = $(this).val();
        $.ajax({
            url: 'getProductType',
            type: 'get',
            dataType: 'json',
            data: {
                idCateProduct: idCateProduct
            },
            success: function (result) {
                let html = '';
                $.each(result, function ($key, $value) {
                    html += '<option value=' + $value['id'] + '>';
                    html += $value['name'];
                    html += '</option>';
                });
                // đổ dữ liệu ra option loại sản phẩm
                $('.proTypeProduct').html(html);
            }
        });
    });
});
