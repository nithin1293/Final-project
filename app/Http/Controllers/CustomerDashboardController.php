<?php

namespace App\Http\Controllers;

use App\Models\Store;

class CustomerDashboardController extends Controller
{
    public function index()
    {
       $stores = Store::all();
    return view('customer_dashboard', compact('stores'));
    }

    public function viewStore($id)
    {
        $store = Store::with('products', 'theme')->findOrFail($id);

        // Decode theme settings (stored as JSON)
        $themeSettings = $store->theme ? json_decode($store->theme->settings, true) : [];

        return view('store_products', compact('store', 'themeSettings'));
    }
}
