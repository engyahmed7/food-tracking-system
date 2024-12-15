<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Settings\ShowBannerData;


class HomeController extends Controller
{
    public function index()
    {
        $settings = app(ShowBannerData::class);
        $product = Product::find($settings->selected_product_id);

        return view('home.home', compact('product'));
    }
}
