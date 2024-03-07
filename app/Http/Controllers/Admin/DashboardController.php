<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $total_brands = Brand::where('status', '!=', '0')->count();
        $total_categories = Category::where('status', '!=', '0')->count();
        $total_products = Product::where('status', '!=', '0')->count();

        $total_purchases_amount = Purchase::where('status', '!=', '0')->sum('amount');
        $total_sales_amount = Sale::where('status', '!=', '0')->sum('amount');
        $total_profit_amount = $total_sales_amount - $total_purchases_amount;

        return view('admin.dashboard', [
            'total_brands' => $total_brands,
            'total_categories' => $total_categories,
            'total_products' => $total_products,
            'total_purchases_amount' => $total_purchases_amount,
            'total_sales_amount' => $total_sales_amount,
            'total_profit_amount' => number_format($total_profit_amount, 2)
        ]);
    }
}
