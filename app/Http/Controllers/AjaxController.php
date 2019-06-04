<?php

namespace App\Http\Controllers;

use App\Models\ProductTypes;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // lấy product type tương ứng với danh mục sản phẩm
    public function getProductType(Request $request)
    {
        $product_type = ProductTypes::where('idCategory', $request->idCateProduct)->get();
        return response()->json($product_type, 200);
    }
}
