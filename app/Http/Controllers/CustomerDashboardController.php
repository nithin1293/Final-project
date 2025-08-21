<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Product;

class CustomerDashboardController extends Controller
{
    /**
     * Display a listing of the stores for the customer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetches all stores to be displayed on the dashboard.
        $stores = Store::all();
        return view('customerDashboard', compact('stores'));
    }

    /**
     * Display the products for a specific store.
     *
     * @param  int  $id The ID of the store.
     * @return \Illuminate\View\View
     */
    public function showStoreProducts($id)
    {
        // Find the store by its ID, or fail.
        $store = Store::findOrFail($id);
        // Fetches all products associated with that store.
        $products = Product::where('store_id', $id)->get();
        return view('store_products', compact('store', 'products'));
    }
}
