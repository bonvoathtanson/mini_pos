<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Import;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests;

class SupplierController extends Controller
{
    // Supplier List
    // view/supplier
    public function index()
    {
        return view('suppliers/index');
    }

    // <des>add new supplier (create/supplier)</des>
    public function create()
    {
        return view('suppliers/create');
    }

    // <des>view filter supplier</des>
    public function filter_supplier()
    {
        return view('suppliers.filter_supplier');
    }

    // <des>edit supplier (edit/supplier)</des>
    // <param name = "$id">suppliers.id</param>
    public function edit($id)
    {
        $supplier = Supplier::find($id);

        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    // <des>view detail all relate with supplier</des>
    // <param name= "$id">suppliers.id</param>
    public function detail($id)
    {
        $supplier = Supplier::find($id);
        $transfers = Import::where('SupplierId', '=', $id)
                        ->where('IsOrder', '=', 1)
                        ->orderBy('ImportDate', 'DESC')->get();

        $oncredits = Import::where('SupplierId', '=', $id)
                        ->where('SubTotal', '>', DB::raw('PayAmount'))
                        ->orderBy('ImportDate', 'DESC')->get();

        $onpayoffs = Import::where('SupplierId', '=', $id)
                        ->where('SubTotal', '<=', DB::raw('PayAmount'))
                        ->orderBy('ImportDate', 'DESC')->get();

        $results = array(
            'supplier' => $supplier,
            'transfers' => $transfers,
            'oncredits' => $oncredits,
            'onpayoffs' => $onpayoffs
        );

        return view('suppliers.detail', $results);
    }

    // <des>ajax request filter supplier (filter/selsupplier)</des>
    // <param name = "$keyword">filter in code, name, phone</param>
    public function filter($keyword='')
    {
        $key = "%$keyword%";
        if($keyword =='empty'){
            $supplers = Supplier::limit(10)->get();
        }else{
            $supplers = Supplier::where('SupplierCode', 'Like', $key)
                                ->orwhere('SupplierName', 'Like', $key)
                                ->orwhere('PhoneNumber', 'Like', $key)
                                ->get();
        }

        $this->SetData($supplers);

        return response()->json($this->Results);
    }

    // <des>ajax request supplier list (view/supplier)</des>
    public function search($keyword = '')
    {
        $key = "%$keyword%";
        $suppliers = Supplier::where('SupplierCode', 'Like', $key)
                            ->orwhere('SupplierName', 'Like', $key)
                            ->orwhere('PhoneNumber', 'Like', $key)
                            ->get();

        $this->SetData($suppliers);

        return response()->json($this->Results);
    }

    // <des>ajax insert supplier (create/supplier)</des>
    public function store(Request $request)
    {
        $supplier = new Supplier();
        $supplier->SupplierCode = $request->SupplierCode;
        $supplier->SupplierName = $request->SupplierName;
        $supplier->Sex = $request->Sex;
        $supplier->PhoneNumber = $request->PhoneNumber;
        $supplier->Address = $request->Address;
        $supplier->LastUpdated = date('Y-m-d H:i:s');
        $supplier->save();

        return response()->json($this->Results);
    }

    // <des>ajax update supplier (edit/supplier)</des>
    public function update(Request $request)
    {
        $id = $request->Id;
        $supplier = Supplier::find($id);
        $supplier->SupplierCode = $request->SupplierCode;
        $supplier->SupplierName = $request->SupplierName;
        $supplier->Sex = $request->Sex;
        $supplier->PhoneNumber = $request->PhoneNumber;
        $supplier->Address = $request->Address;
        $supplier->LastUpdated = date('Y-m-d H:i:s');
        $supplier->save();
        return response()->json($this->Results);
    }

    // <des>ajax delete supplier</des>
    public function destroy($id)
    {
        $rowaffect = Supplier::find($id)->delete();
        if($rowaffect == 0){
            $this->SetError(true);
            $this->SetMessage('ការលុប​ទិន្នន័យមានបញ្ហាសូមព្យា​យាម​ម្តងទៀត');
        }

        return response()->json($this->Results);
    }
}
