<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $lowStockCount = Product::where('stock', '<', 10)->count();

        // Get recent products for the dashboard table
        $recentProducts = Product::latest()->take(5)->get();

        return view('dashboard', compact('totalProducts', 'totalStock', 'lowStockCount', 'recentProducts'));
    }
}
