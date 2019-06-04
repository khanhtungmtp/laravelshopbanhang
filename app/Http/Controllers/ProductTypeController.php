<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductTypeRequest;
use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductTypes;
use Illuminate\Http\Request;
use Validator;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product_type = ProductTypes::paginate(5);
        return view('admin.pages.product-type.list', compact('product_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // hiện trang thêm
        $category = Categories::where('status', 1)->get();
        return view('admin.pages.product-type.add', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductTypeRequest $request)
    {
        // bắt đầu thêm
        $data         = $request->all();
        $data['slug'] = str_slug($request->name);
        $result       = ProductTypes::create($data);
        if ($result)
        {
            return redirect()->route('product-type.index')->with('message', 'Thêm mới loại sản phẩm thành công');
        } else
        {
            return back()->with('message', 'Có lỗi khi thêm, vui lòng kiểm tra lại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
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
        // hiện sửa
        $product_type = ProductTypes::find($id);
        $category     = Categories::where('status', 1)->get();
        return response()->json(['producttype' => $product_type, 'category' => $category], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // bắt đầu sửa
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:2|max:255|unique:producttype,name,' . $id
            ],
            [
                'name.unique'   => ':attributes đã tồn tại',
                'name.required' => ':attributes không được bỏ trống',
                'name.min'      => ':attributes phải từ 2-255 ký tự',
                'name.max'      => ':attributes phải từ 2-255 ký tự',
            ]
        );
        if ($validator->fails())
        {
            return response()->json(['error' => 'true', 'message' => $validator->errors()], 200);
        }
        $product_type  = ProductTypes::find($id);
        $product_type->update([
            'idCategory' => $request->idCategory,
            'name'       => $request->name,
            'slug'       => str_slug($request->name),
            'status'     => $request->status
        ]);
        return response()->json(['success' => 'Cập nhập loại sản phẩm thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // xóa
        $product_type = ProductTypes::find($id);
        if ($product_type->delete())
        {
            return response()->json(['message' => 'Đã xóa thành công loại sản phẩm có id ' . $id], 200);
        } else
        {
            return response()->json(['message' => 'Đã xóa không thành công loại sản phẩm có id ' . $id], 200);
        }
    }
}
