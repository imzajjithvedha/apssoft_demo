<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::where('status', '1')->get();
        $categories = Category::where('status', '1')->get();
        $products_query = Product::where('status', '!=', '0');

        if($request->ajax()) {

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $page = ($start / $length) + 1;

            $total_records = $products_query->count();
            $products = $products_query->skip($start)->take($length)->orderBy('id', 'desc')->get();
            $records_filtered = $products->count();

            foreach($products as $key => $product) {
                $product->action = '
                <a id="'.$product->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <a id="'.$product->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

                $product->brand = Brand::find($product->brand)->name;

                $product->category = Brand::find($product->category)->name;

                if($product->status == 1) {
                    $product->status = '<span class="badge text-bg-success">Activate</span>';
                }
                else {
                    $product->status = '<span class="badge text-bg-danger">Deactivate</span>';
                }
            }

            return response()->json([
                'data' => $products,
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records
            ]);
        }

        return view('admin.products', [
            'brands' => $brands,
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $product = new Product();
        $data = $request->all();
        $product->create($data);

        return redirect()->route('admin.products.index')->with('success', 'Successfully Created!');
    }

    public function edit(Product $product)
    {
        return response($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $product->fill($data)->save();

        return redirect()->route('admin.products.index')->with('success', "Successfully Updated!");
    }

    public function delete(Product $product)
    {
        $product->status = '0';
        $product->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }
}
