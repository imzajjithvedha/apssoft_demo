<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands_query = Brand::where('status', '!=', '0');

        if($request->ajax()) {

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $page = ($start / $length) + 1;

            $total_records = $brands_query->count();
            $brands = $brands_query->skip($start)->take($length)->orderBy('id', 'desc')->get();
            $records_filtered = $brands->count();

            foreach($brands as $key => $brand) {
                $brand->action = '
                <a id="'.$brand->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <a id="'.$brand->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

                if($brand->status == 1) {
                    $brand->status = '<span class="badge text-bg-success">Activate</span>';
                }
                else {
                    $brand->status = '<span class="badge text-bg-danger">Deactivate</span>';
                }
            }

            return response()->json([
                'data' => $brands,
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records
            ]);
        }

        return view('admin.brands');
    }

    public function store(Request $request)
    {
        $brand = new Brand();
        $data = $request->all();
        $brand->create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Successfully Created!');
    }

    public function edit(Brand $brand)
    {
        return response($brand);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->all();
        $brand->fill($data)->save();

        return redirect()->route('admin.brands.index')->with('success', "Successfully Updated!");
    }

    public function delete(Brand $brand)
    {
        $brand->status = '0';
        $brand->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }
}
