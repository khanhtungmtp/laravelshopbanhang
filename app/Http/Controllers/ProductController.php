<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductTypes;
use Illuminate\Support\Facades\File;
use Validator;

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
        $product = Product::paginate(10);
        //        dd($product);die;
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
            $file      = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file_type = strtolower($file->getMimeType());
            $file_size = $file->getSize();
            $img_type  = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            // chỉ chấp nhận file hình có đuôi như trên
            if (in_array($file_type, $img_type))
            {
                if ($file_size < 1048576)
                {
                    $file_name = date('DD-mm-yyyy') . '-' . rand() . '-' . $file_name;
                    if (empty($errors))
                    {
                        if (!$file->move('img/upload/product/', $file_name))
                        {
                            return back()->with(['error' => 'Có lỗi khi upload ảnh']);
                        }
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
        $data          = $request->all();
        $data['image'] = $file_name;
        $data['slug']  = str_slug($file_name);

        Product::create($data);
        return redirect()->route('product.index')->with('message', 'Thêm mới sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // hiện trang sửa
        $product_type = ProductTypes::where('status', 1)->get();
        $category     = Categories::where('status', 1)->get();
        $product      = Product::find($id);
        return response()->json(['category' => $category, 'product_type' => $product_type, 'product' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductRequest $request, $id)
    {
        $product   = Product::find($id);
        $data      = $request->all();
        $data['slug'] = str_slug($request->name);
        // kiểm tra có upload hình
        if ($request->hasFile('image'))
        {
            $file      = $request->file('image');
            $file_name = $file->getClientOriginalName();
            $file_type = strtolower($file->getMimeType());
            $file_size = $file->getSize();
            $img_type  = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            // chỉ chấp nhận file hình có đuôi như trên
            if (in_array($file_type, $img_type))
            {
                if ($file_size < 1048576)
                {
                    $file_name = date('DD-mm-yyyy') . '-' . rand() . '-' . $file_name;
                    if (empty($errors))
                    {
                        if ($file->move('img/upload/product/', $file_name))
                        {
                            $data['image'] = $file_name;
                            if (File::exists('img/upload/product/', $product->image))
                            {
                                // xóa file
                                unlink('img/upload/product/', $product->image);
                            }
                        } else
                        {
                            return back()->with(['error' => 'Có lỗi khi upload ảnh']);
                        }
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
            // không up hình thì lấy hình củ
            $data['image'] = $product->image;
        }
        $product->update($data);
        return response()->json(['message' => 'Cập nhập sản phẩm thành công'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        return response()->json(['success' => 'Xóa thành công sản phẩm có id' . $id], 200);
    }
}
