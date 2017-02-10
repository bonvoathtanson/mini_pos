<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Expanse;
use App\Models\Supplier;
use App\Models\Import;
use Illuminate\Http\Request;

use App\Http\Requests;

class ExpanseController extends Controller
{
    public function index()
    {
        return view('expanses.index');
    }
    public function otherexpanse()
    {
        return view('expanses.other');
    }
    public function report()
    {
        $expanse = Expanse::all();
        return view('reports.expanse',['expanses' => $expanse]);
    }
    public function create($id)
    {
        $supplier = Supplier::find($id);
        $imports = Import::where('SupplierId', '=', $id)
                    ->where('SubTotal', '>', DB::raw('PayAmount'))
                    ->orderBy('ImportDate', 'ASC')->get();
        $results = array(
            'supplier' => $supplier,
            'imports' => $imports
        );
        return view('expanses/create', $results);
    }

    public function search(Request $request){

        $fromDate = $request->expanseFromDate;
        $toDate = $request->expanseToDate;
        $supplyId = $request->supplyId;
        if( $fromDate =='' && $toDate =='' && $supplyId ==''){
            $expanses = Expanse::orderBy('ExpanseDate','DESC')->get();
        }else{
            $query = Expanse::query();
            if(!empty($fromDate)){
                $query->whereDate('ExpanseDate', '>=', $fromDate);
            }
            if(!empty($toDate)){
                $query->whereDate('ExpanseDate', '<=', $toDate);
            }
            if(!empty($supplyId)){
                $query->where('SupplierId', '=', $supplyId);
            }
            $expanses = $query->orderBy('ExpanseDate','DESC')->get();
        }

        $expanses->load('Supplier');
        $this->SetData($expanses);

        return response()->json($this->Results);
    }

    public function store(Request $request)
    {
        if($request->ExpanseType == 0)
        {
            $this->SaveOtherExpanse($request);
        }
        else if($request->ExpanseType == 1)
        {
            $this->SaveMoreExpanse($request);
        }

        return response()->json($this->Results);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $expanse = Expanse::find($id);
            $rowAffect = $expanse->delete();
            if($rowAffect == 0)
            {
                $this->Results['IsError'] = true;
                $this->SetMessage('ការលុប​ទិន្នន័យមានបញ្ហាសូមព្យា​យាម​ម្តងទៀត');
            }else{
                if($expanse->ExpanseType == 1)
                {
                    $this->ResetPayment($expanse->ImportId, $expanse->TotalAmount);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            $this->Fail();
            $this->SetMessage($e);
            DB::rollBack();
        }

        return response()->json($this->Results);
    }

    private function SaveOtherExpanse($request)
    {
        $expanse = new Expanse();
        $expanse->ExpanseDate = date_create($request->ExpanseDate);
        $expanse->TotalAmount = $request->TotalAmount;
        $expanse->ExpanseType = $request->ExpanseType;
        $expanse->Description = $request->Description;
        $expanse->DateCreated = date('Y-m-d H:i:s');
        $expanse->save();
    }

    private function SaveMoreExpanse($request)
    {
        $importIds = $request->ImportIds;
        $imports = Import::whereIn('Id', $importIds)->get();
        foreach ($imports as $index => $import) {
            $expanse = new Expanse();
            $expanse->ImportId = $import->Id;
            $payAmount = $import->SubTotal - $import->PayAmount;
            $expanse->SupplierId = $request->SupplierId;
            $expanse->ExpanseDate = date_create($request->ExpanseDate);
            $expanse->TotalAmount = $payAmount;
            $expanse->ExpanseType = 1;
            $expanse->Description = 'បងលុយអ្នកផ្គត់ផ្គង់ឈ្មោះ ['.$import->Supplier->SupplierName.'] ទំទិញ '.$import->item->ItemName;
            $expanse->DateCreated = date('Y-m-d H:i:s');
            $expanse->save();
            $this->UpdatePayAmount($import->Id, $import->SubTotal);
        }
    }

    private function UpdatePayAmount($importId, $payAmount)
    {
        $import = Import::find($importId);
        $import->PayAmount = $payAmount;
        $import->save();
    }

    private function ResetPayment($importId, $payAmount)
    {
        $import = Import::find($importId);
        $import->PayAmount = ($import->PayAmount - $payAmount);
        $import->save();
    }
}
