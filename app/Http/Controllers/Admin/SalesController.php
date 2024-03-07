<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        if(session('sales')) {
            $start_date = session('start_date');
            $end_date = session('end_date');

            session()->forget('start_date');
            session()->forget('end_date');
        }
        else {
            $start_date = null;
            $end_date = null;
        }

        $products = Product::where('status', '1')->get();

        if($request->ajax()) {

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $page = ($start / $length) + 1;

            if(session('sales')) {
                $sales_query = session('sales');
                session()->forget('sales');
            }
            else {
                $sales_query = Sale::where('status', '!=', '0')->orderBy('date', 'desc')->get();
            }

            $total_records = $sales_query->count();
            $sales = $sales_query->skip($start)->take($length);
            $records_filtered = $sales->count();

            foreach($sales as $key => $sale) {
                $sale->action = '
                <a id="'.$sale->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <a id="'.$sale->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

                $sale->product = Product::find($sale->product)->name;

                if($sale->status == 1) {
                    $sale->status = '<span class="badge text-bg-success">Approved</span>';
                }
                else {
                    $sale->status = '<span class="badge text-bg-danger">Pending</span>';
                }
            }

            return response()->json([
                'data' => $sales,
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records
            ]);
        }

        return view('admin.sales', [
            'products' => $products,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::find($request->product);

        if($product->stock_quantity < $request->quantity) {
            return redirect()->route('admin.sales.index')->with('error', 'Stock Limit Reached!');
        }

        $product->stock_quantity = $product->stock_quantity - $request->quantity;
        $product->save();

        $sale = new Sale();
        $data = $request->all();
        $data['status'] = '1';
        $sale->create($data);

        return redirect()->route('admin.sales.index')->with('success', 'Successfully Created!');
    }

    public function edit(Sale $sale)
    {
        return response($sale);
    }

    public function update(Request $request, Sale $sale)
    {
        $product = Product::find($request->product);
        
        if(($product->stock_quantity + $sale->quantity) < $request->quantity) {
            return redirect()->route('admin.sales.index')->with('error', 'Stock Limit Reached!');
        }

        $product->stock_quantity = ($product->stock_quantity + $sale->quantity) - $request->quantity;
        $product->save();

        $data = $request->all();
        $sale->fill($data)->save();

        return redirect()->route('admin.sales.index')->with('success', "Successfully Updated!");
    }

    public function delete(Sale $sale)
    {
        $product = Product::find($sale->product);
        $product->stock_quantity = $product->stock_quantity + $sale->quantity;
        $product->save();

        $sale->status = '0';
        $sale->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function filter(Request $request)
    {
        if($request->has('reset')) {
            $filter_keys = ['sales', 'start_date', 'end_date'];
            foreach($filter_keys as $key) {
                session([$key => null]);
            }

            return redirect()->route('admin.sales.index');
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $sales = Sale::where('status', '!=', '0');

        if($start_date != null) {
            if($end_date == null) {
                $sales->whereDate('date', $start_date);
            }
            else {
                $sales->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
            }
        }

        $sales = $sales->orderBy('date', 'desc')->get();

        if($request->has('download')) {
            $data = json_decode($sales);

            $csv_data = '';
            $headers = ['Product', 'Date', 'quantity', 'Amount'];

            if(!empty($data)) {

                $csv_data .= implode(',', $headers) . "\n";
                $total_quantity = 0;
                $total_amount = 0;

                foreach($data as $arr) {
                    $arr->product = Product::find($arr->product)->name;

                    $arr->status = ucfirst($arr->status);

                    $row_data = [$arr->product, $arr->date, $arr->quantity, $arr->amount];

                    $total_quantity += $arr->quantity;

                    $total_amount += $arr->amount;

                    $csv_data .= implode(',', $row_data) . "\n";
                }

                $csv_data .= "\n";

                $total_row = ['', 'Total', $total_quantity, $total_amount, ''];
                $csv_data .= implode(',', $total_row) . "\n";
            }

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="Sales Report.csv"',
            ];
    
            return Response::make($csv_data, 200, $headers);
        }

        session([
            'sales' => $sales,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

        return redirect()->route('admin.sales.index');
    }
}