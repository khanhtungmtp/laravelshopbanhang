<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductTypes;
use App\Services\ImageService;
use File;
use Validator;

class ProductController extends Controller
{
    protected $image_service;
    public function __construct(ImageService $imageService)
    {
        $this->image_service = $imageService;
    }

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
        // kiểm tra có upload hình
        if ($request->hasFile('image'))
        {
            $file      = $request->file('image');
            if ($this->image_service->checkFile($file) == 1) {
                $filename = $this->image_service->moveImage('img/upload/product/',$file);

            } elseif ($this->image_service->checkFile($file) == 0){
                return back()->with(['error' => 'Bạn không được upload hình quá 1MB']);
            } else {
                return back()->with(['error' => 'File bạn vừa upload không phải là hình, hoặc có đuôi file không hỗ trợ']);
            }
        } else
        {
            return back()->with(['error' => 'Bạn chưa chọn hình sản phẩm']);
        }
        $data          = $request->all();
        $data['image'] = $filename;
        $data['slug']  = utf8tourl($filename);
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
        $data['slug'] = utf8tourl($request->name);
        // kiểm tra có upload hình
        if ($request->hasFile('image'))
        {
            $file      = $request->file('image');
            if ($this->image_service->checkFile($file) == 1) {
                $filename = $this->image_service->moveImage('img/upload/product/',$file);

            } elseif ($this->image_service->checkFile($file) == 0){
                return back()->with(['error' => 'Bạn không được upload hình quá 1MB']);
            } else {
                return back()->with(['error' => 'File bạn vừa upload không phải là hình, hoặc có đuôi file không hỗ trợ']);
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
