<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Categories::paginate(5);
        return view('admin.pages.category.list', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.pages.category.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        //
        Categories::create([
            'name'   => $request->name,
            'slug'   => str_slug($request->name),
            'status' => $request->status,
        ]);
        return redirect(route('category.index'))->with('message','Thêm mới danh mục thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param App\Models\Categories $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Categories::find($id);
        return response()->json($category, 200);
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
        // validate
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|min:2|max:255|unique:categories,name,' . $id
            ],
            [
                'name.unique'   => ':attributes đã tồn tại',
                'name.required' => 'Tên danh mục không được bỏ trống',
                'name.min'      => 'Tên danh mục phải từ 2-255 ký tự',
                'name.max'      => 'Tên danh mục phải từ 2-255 ký tự'
            ]);
        if ($validator->fails())
        {
            return response()->json(['error' => 'true', 'message' => $validator->errors()], 200);
        }
        $category = Categories::find($id);
        // update
        $category->update([
            'name'   => $request->name,
            'slug'   => str_slug($request->name),
            'status' => $request->status,
        ]);
        return response()->json(['message' => 'Cập nhập danh mục thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::find($id);
        $category->delete();
        return response()->json(['message' => 'Xóa danh mục thành công']);
    }
}
