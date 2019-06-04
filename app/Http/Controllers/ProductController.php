<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductTypes;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product = Product::all();
        return view('admin.pages.product.list', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $category     = Categories::where('status', 1)->get();
        $product_type = ProductTypes::where('status', 1)->get();
        return view('admin.pages.product.add', compact('category', 'product_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = [];
        // kiểm tra có upload hình
        if ($request->hasFile('image'))
        {
            $file      = $request->image;
            $file_name = $file->getClientOriginalName();
            $file_type = strtolower($file->getMimeType());
            $file_size = $file->getSize();
            $img_type  = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            // chỉ chấp nhận file hình có đuôi như trên
            if (in_array($file_type, $img_type, true))
            {
                if ($file_size < 1048576)
                {
                    $file_name = date('DD-mm-yyyy') . '-' . str_slug($file_name);
                    if ($file->move('img/upload/product/', $file_name))
                    {
                        $data['image'] = $file_name;
                    } else
                    {
                        return back()->with(['error' => 'Có lỗi khi upload ảnh']);
                    }
                } else
                {
                    return back()->with(['error' => 'Bạn không upload hình quá 1MB']);
                }
            } else
            {
                return back()->with(['error' => 'File không phải là hình, hoặc có đuôi file không hỗ trợ']);
            }
        } else
        {
            return back()->with(['error' => 'Bạn chưa chọn hình sản phẩm']);
        }
        if (empty($errors))
        {
            $data         = $request->all();
            $data['slug'] = str_slug($file_name);
            Product::create($data);
            return redirect()->route('product.index')->with('message', 'Thêm mới sản phẩm thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Product             $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
