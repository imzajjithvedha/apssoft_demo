<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories_query = Category::where('status', '!=', '0');

        if($request->ajax()) {

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $page = ($start / $length) + 1;

            $total_records = $categories_query->count();
            $categories = $categories_query->skip($start)->take($length)->orderBy('id', 'desc')->get();
            $records_filtered = $categories->count();

            foreach($categories as $key => $category) {
                $category->action = '
                <a id="'.$category->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <a id="'.$category->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

                if($category->status == 1) {
                    $category->status = '<span class="badge text-bg-success">Activate</span>';
                }
                else {
                    $category->status = '<span class="badge text-bg-danger">Deactivate</span>';
                }
            }

            return response()->json([
                'data' => $categories,
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records
            ]);
        }

        return view('admin.categories');
    }

    public function store(Request $request)
    {
        $category = new Category();
        $data = $request->all();
        $category->create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Successfully Created!');
    }

    public function edit(Category $category)
    {
        return response($category);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->all();
        $category->fill($data)->save();

        return redirect()->route('admin.categories.index')->with('success', "Successfully Updated!");
    }

    public function delete(Category $category)
    {
        $category->status = '0';
        $category->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }
}
