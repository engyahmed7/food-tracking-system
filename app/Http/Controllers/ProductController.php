<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Settings\FooterSettings;
use App\Settings\HeaderSettings;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::paginate(2);
        $headerSettings = app(HeaderSettings::class);
        $headerItems = $headerSettings->header_items;
        $footerSettings = app(FooterSettings::class);
        $footerSettingsArray = $footerSettings->toArray();

        $categoryNames = Category::whereIn('id', $footerSettingsArray['categories'])->pluck('name', 'id');

        $categories = Category::all();
        return view('products.index', compact('products', 'headerItems', 'footerSettingsArray', 'categoryNames', 'categories'));
    }

    public function show($id)
    {
        $product = Product::find($id);
        $headerSettings = app(HeaderSettings::class);
        $headerItems = $headerSettings->header_items;

        $footerSettings = app(FooterSettings::class);
        $footerSettingsArray = $footerSettings->toArray();

        $categoryNames = Category::whereIn('id', $footerSettingsArray['categories'])->pluck('name', 'id');


        return view('products.show', compact('product', 'headerItems', 'footerSettingsArray', 'categoryNames'));
    }
}
