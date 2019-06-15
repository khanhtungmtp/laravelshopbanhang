<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    public function __construct()
    {
        $category     = Categories::where('status', 1)->get();
        $product_type = ProductTypes::where('status', 1)->get();
        view()->share(['category' => $category, 'product_type' =>$product_type]);
        if (Auth::check()){
            $user = Auth::user();
            view()->share(['user' => $user]);
        }
    }

    public function index()
    {
        return view('client.pages.index');
    }
}
