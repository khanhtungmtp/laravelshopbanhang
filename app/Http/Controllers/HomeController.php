<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function __construct()
    {
        $category     = Categories::where('status', 1)->get();
        $product_type = ProductTypes::where('status', 1)->get();
        view()->share(['category' => $category, 'product_type' => $product_type]);
    }

    public function index()
    {
        // samsung
        $product_samsung = Product::where('status', 1)->where('idProductType', 1)->get();
        // nokia
        $product_nokia = Product::where('status', 1)->where('idProductType', 2)->get();
        return view('client.pages.index',compact('product_samsung', 'product_nokia'));
    }
}
