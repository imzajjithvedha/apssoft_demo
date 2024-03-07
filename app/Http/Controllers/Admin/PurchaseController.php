<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class PurchaseController extends Controller
{
    public function index(Request $request)
    {
        if(session('purchases')) {
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
        $purchases_query = Purchase::where('status', '!=', '0');

        if($request->ajax()) {

            $length = $request->input('length', 10);
            $start = $request->input('start', 0);
            $page = ($start / $length) + 1;

            if(session('purchases')) {
                $purchases_query = session('purchases');
                session()->forget('purchases');
            }
            else {
                $purchases_query = Purchase::where('status', '!=', '0')->orderBy('date', 'desc')->get();
            }

            $total_records = $purchases_query->count();
            $purchases = $purchases_query->skip($start)->take($length);
            $records_filtered = $purchases->count();

            foreach($purchases as $key => $purchase) {
                $purchase->action = '
                <a id="'.$purchase->id.'" class="edit btn btn-warning btn-sm mx-1 rounded-0" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                <a id="'.$purchase->id.'" class="delete btn btn-danger btn-sm mx-1 rounded-0" title="Delete"><i class="bi bi-trash"></i></a>';

                $purchase->product = Product::find($purchase->product)->name;

                if($purchase->status == 1) {
                    $purchase->status = '<span class="badge text-bg-success">Approved</span>';
                }
                else {
                    $purchase->status = '<span class="badge text-bg-danger">Pending</span>';
                }
            }

            return response()->json([
                'data' => $purchases,
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $total_records
            ]);
        }

        return view('admin.purchases', [
            'products' => $products,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    public function store(Request $request)
    {
        $product = Product::find($request->product);
        $product->stock_quantity = $product->stock_quantity + $request->quantity;
        $product->save();

        $purchase = new Purchase();
        $data = $request->all();
        $data['status'] = '1';
        $purchase->create($data);

        return redirect()->route('admin.purchases.index')->with('success', 'Successfully Created!');
    }

    public function edit(Purchase $purchase)
    {
        return response($purchase);
    }

    public function update(Request $request, Purchase $purchase)
    {
        $product = Product::find($request->product);
        $product->stock_quantity = ($product->stock_quantity - $purchase->quantity) + $request->quantity;
        $product->save();

        $data = $request->all();
        $purchase->fill($data)->save();

        return redirect()->route('admin.purchases.index')->with('success', "Successfully Updated!");
    }

    public function delete(Purchase $purchase)
    {
        $product = Product::find($purchase->product);
        $product->stock_quantity = $product->stock_quantity - $purchase->quantity;
        $product->save();

        $purchase->status = '0';
        $purchase->save();

        return redirect()->back()->with('success', 'Successfully Deleted!');
    }

    public function filter(Request $request)
    {
        if($request->has('reset')) {
            $filter_keys = ['purchases', 'start_date', 'end_date'];
            foreach($filter_keys as $key) {
                session([$key => null]);
            }

            return redirect()->route('admin.purchases.index');
        }

        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $purchases = Purchase::where('status', '!=', '0');

        if($start_date != null) {
            if($end_date == null) {
                $purchases->whereDate('date', $start_date);
            }
            else {
                $purchases->whereDate('date', '>=', $start_date)->whereDate('date', '<=', $end_date);
            }
        }

        $purchases = $purchases->orderBy('date', 'desc')->get();

        if($request->has('download')) {
            $data = json_decode($purchases);

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
                'Content-Disposition' => 'attachment; filename="Purchases Report.csv"',
            ];
    
            return Response::make($csv_data, 200, $headers);
        }

        session([
            'purchases' => $purchases,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);

        return redirect()->route('admin.purchases.index');
    }
}