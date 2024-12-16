<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Settings\FooterSettings;
use App\Settings\HeaderSettings;
use Illuminate\Http\Request;
use App\Settings\ShowBannerData;


class HomeController extends Controller
{
    public function index()
    {
        $settings = app(ShowBannerData::class);
        $product = Product::find($settings->selected_product_id);

        $headerSettings = app(HeaderSettings::class);
        $headerItems = $headerSettings->header_items;

        $footerSettings = app(FooterSettings::class);
        $footerSettingsArray = $footerSettings->toArray();
        $categoryNames = Category::whereIn('id', $footerSettingsArray['categories'])->pluck('name', 'id');

        // dd($footerSettingsArray);


        return view('home.index', compact('product', 'headerItems', 'footerSettingsArray', 'categoryNames'));
    }
}
