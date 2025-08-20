<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $stores = Store::where('user_id', Auth::user()->id)->get();
         

        return view('dashboard', compact('stores'));
    }

    public function viewStore($id)
    {
        $store = Store::with('products', 'theme')->findOrFail($id);

        // Decode theme settings (stored as JSON)
        $themeSettings = $store->theme ? json_decode($store->theme->settings, true) : [];

        return view('store_products', compact('store', 'themeSettings'));
    }
}
