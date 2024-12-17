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
        $products = Product::paginate(3);

        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::find($id);


        return view('products.show', compact('product'));
    }
}
