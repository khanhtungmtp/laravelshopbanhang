<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductTypes;
use Auth;
use Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * view share global
     */
    public function __construct()
    {
        $category     = Categories::where('status', 1)->get();
        $product_type = ProductTypes::where('status', 1)->get();
        view()->share(['category' => $category, 'product_type' => $product_type]);
    }

    public function addCart(Request $request, $id)
    {
        $product = Product::find($id);
        if ($request->qty)
        {
            $qty = $request->qty;
        } else
        {
            $qty = 1;
        }
        $cart = ['id' => $id, 'name' => $product->name, 'qty' => $qty, 'price' => $product->price, 'options' => ['img' => $product->image]];
        Cart::add($cart);
        return back()->with('message', 'Đã mua hàng ' . $product->name . ' thành công');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::content();
        //dd($carts);
        return view('client.pages.cart', compact('carts'));
    }

    /**
     * checkout
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $user  = Auth::user();
        $price = str_replace(',', '', Cart::total());
        return view('client.pages.checkout', compact('user', 'price'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * thêm mới địa chỉ giao hàng
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if ($request->ajax())
        {
            if ($request->qty == 0)
            {
                return response()->json(['error' => 'Sản phẩm phải >= 1'], 200);
            } else
            {
                Cart::update($id, $request->qty);
                return response()->json(['message' => 'Cập nhập số lượng sản phẩm thành công'], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        return response()->json(['message' => 'Xóa thành công sản phẩm ra khỏi giỏ hàng'], 200);
    }
}
