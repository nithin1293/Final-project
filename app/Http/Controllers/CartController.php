<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show cart page (cart items come from localStorage in frontend JS).
     */
    public function index()
    {
        return view('cart'); // resources/views/cart.blade.php
    }
}
