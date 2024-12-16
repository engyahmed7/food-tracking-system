<?php


namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Settings\FooterSettings;
use App\Settings\HeaderSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function viewCart()
    {
        $cart = $this->getCart();
        $cartItems = $cart->items;

        $headerSettings = app(HeaderSettings::class);
        $headerItems = $headerSettings->header_items;

        $footerSettings = app(FooterSettings::class);
        $footerSettingsArray = $footerSettings->toArray();

        $categoryNames = Category::whereIn('id', $footerSettingsArray['categories'])->pluck('name', 'id');



        return view('cart.index', compact('cartItems', 'headerItems', 'footerSettingsArray', 'categoryNames'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return back()->with('error', 'Product not found!');
        }

        $cart = $this->getCart();

        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.view')->with('success', 'Product added to cart!');
    }

    public function updateCart(Request $request)
    {
        $cart = $this->getCart();
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
        }

        return redirect()->route('cart.view')->with('success', 'Cart updated!');
    }

    public function removeFromCart(Request $request)
    {
        $cart = $this->getCart();
        $cartItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($cartItem) {
            $cartItem->delete();
        }

        return redirect()->route('cart.view')->with('success', 'Product removed from cart!');
    }

    public function checkout()
    {
        $cart = $this->getCart();
        $cartItems = $cart->items;

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty!');
        }


        return redirect()->route('home')->with('success', 'Checkout successful!');
    }

    protected function getCart()
    {
        if (Auth::check()) {
            $cart = Auth::user()->cart()->first();

            if (!$cart) {
                $cart = Cart::create(['user_id' => Auth::id()]);
            }

            return $cart;
        }

        return Cart::firstOrCreate(['user_id' => 0]);
    }
}
