<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryRequest;
use Validator;
use Auth;

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
        $user = Auth::user();
        if ($user->can('view',Categories::class)){
            $category = Categories::paginate(5);
            return view('admin.pages.category.list', compact('category'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = Auth::user();
        if ($user->can('create',Categories::class)) {
            return view('admin.pages.category.add');
        }
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
        $user = Auth::user();
        if ($user->can('store',Categories::class))
        {
            Categories::create([
                'name'   => $request->name,
                'slug'   => str_slug($request->name),
                'status' => $request->status,
            ]);
            return redirect(route('category.index'))->with('message','Thêm mới danh mục thành công');
        }
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
        $user = Auth::user();
        if ($user->can('update',Categories::class))
        {
            $category = Categories::find($id);
            return response()->json($category, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param                          $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $user = Auth::user();
        if ($user->can('update',Categories::class))
        {
            $category = Categories::find($id);
            // update
            $category->update([
                'name'   => $request->name,
                'slug'   => str_slug($request->name),
                'status' => $request->status,
            ]);
            return response()->json(['message' => 'Cập nhập danh mục thành công']);
        }
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
