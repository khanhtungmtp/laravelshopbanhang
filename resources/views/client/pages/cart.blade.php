@extends('client.layouts.master')

@section('title')
    Giỏ hàng
@endsection

@section('content')
    <div class="page-head_agile_info_w3l">
    </div>
    <!-- page -->
    <div class="services-breadcrumb">
        <div class="agile_inner_breadcrumb">
            <div class="container">
                <ul class="w3_short">
                    <li>
                        <a href="/">Trang chủ</a>
                        <i>|</i>
                    </li>
                    <li>Giỏ hàng</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- //page -->
    <!-- checkout page -->
    <div class="privacy py-sm-5 py-4">
        <div class="container py-xl-4 py-lg-2">
            <!-- tittle heading -->
            <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
                <span>G</span>iỏ hàng
            </h3>
            <!-- //tittle heading -->
            <div class="checkout-right">
                <h4 class="mb-sm-4 mb-3">Bạn có:
                    <span>{{ Cart::count() }} sản phẩm trong giỏ hàng</span>
                </h4>
                <div class="table-responsive">
                    <table class="timetable_sub">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Hình</th>
                            <th>Số lượng</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Xóa</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($carts as $cart)
                            <?php $i=1 ?>
                            <tr class="rem1">
                                <td class="invert">1</td>
                                <td>
                                    <a href="#">
                                        <img src="img/upload/product/{{ $cart->options->img }}" height="100" alt="{{ $cart->name }}" class="img-responsive">
                                    </a>
                                </td>
                                <td class="invert">
                                    <div class="quantity">
                                        <div class="quantity-select">
                                            <input type="number" class="qty" value="{{ $cart->qty }}" name="qty" data-id="{{ $cart->rowId }}">
                                        </div>
                                    </div>
                                </td>
                                 <td class="invert">{{ $cart->name }}</td>
                                <td class="invert">{{ $cart->price }}</td>
                                <td class="invert">
                                    <div class="rem">
                                        <div class="close1" data-id="{{ $cart->rowId }}"> </div>
                                    </div>
                                </td>
                            </tr>
                            <?php $i++ ?>
                        @endforeach
                        </tbody>
                    </table>
                    <h4 class="mb-sm-4 mb-3 pull-right">Tổng thanh toán {{ Cart::total() }}</h4>
                    <!-- delete Modal-->
                    <div class="modal fade" id="deleteCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Bạn có chắc chắn muốn xóa sản phẩm này ?</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                </div>
                                <div class="modal-body" style="margin-left: 183px;">
                                    <button type="button" class="btn btn-success confirmDelCart">Có</button>
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Không</button>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout-left">
                <div class="address_form_agile mt-sm-5 mt-4">
                    <h4 class="mb-sm-4 mb-3">Add a new Details</h4>
                    <form action="payment.html" method="post" class="creditly-card-form agileinfo_form">
                        <div class="creditly-wrapper wthree, w3_agileits_wrapper">
                            <div class="information-wrapper">
                                <div class="first-row">
                                    <div class="controls form-group">
                                        <input class="billing-address-name form-control" type="text" name="name" placeholder="Full Name" required="">
                                    </div>
                                    <div class="w3_agileits_card_number_grids">
                                        <div class="w3_agileits_card_number_grid_left form-group">
                                            <div class="controls">
                                                <input type="text" class="form-control" placeholder="Mobile Number" name="number" required="">
                                            </div>
                                        </div>
                                        <div class="w3_agileits_card_number_grid_right form-group">
                                            <div class="controls">
                                                <input type="text" class="form-control" placeholder="Landmark" name="landmark" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="controls form-group">
                                        <input type="text" class="form-control" placeholder="Town/City" name="city" required="">
                                    </div>
                                    <div class="controls form-group">
                                        <select class="option-w3ls">
                                            <option>Select Address type</option>
                                            <option>Office</option>
                                            <option>Home</option>
                                            <option>Commercial</option>

                                        </select>
                                    </div>
                                </div>
                                <button class="submit check_out btn">Delivery to this Address</button>
                            </div>
                        </div>
                    </form>
                    <div class="checkout-right-basket">
                        <a href="payment.html">Make a Payment
                            <span class="far fa-hand-point-right"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //checkout page -->
@endsection
