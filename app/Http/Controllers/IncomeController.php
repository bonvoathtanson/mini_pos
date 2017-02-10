<?php

namespace App\Http\Controllers;
use DB;
use App\Models\Customer;
use App\Models\Income;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests;

class IncomeController extends Controller
{
    public function index()
    {
        return view('incomes.index');
    }

    public function otherincome()
    {
        return view('incomes.other');
    }

    public function edit($id)
    {
        $income = Income::find($id);

        return view('incomes.edit', ['income' => $income]);
    }

    public function create()
    {
        return view('incomes.create');
    }

    public function search(Request $request)
    {
      
      $customerId = $request->customerId;
      $fromDate = $request->incomeFromDate;
      $toDate = $request->incomeToDate;

      if($customerId =='' && $fromDate =='' && $toDate =='' ){
        $incomes = Income::all();
      }else{
        $query = Income::query();
        if(!Empty($customerId)){
            $query->where('CustomerId', '=', $customerId);
        }
        if(!Empty($fromDate)){
            $query->whereDate('IncomeDate', '>=', $fromDate);
        }
        if(!Empty($toDate)){
            $query->whereDate('IncomeDate', '<=', $toDate);
        }
        $incomes = $query->get();
      }

        $incomes->load('Customer');
        $this->SetData($incomes);

        return response()->json($this->Results);
    }

    public function store(Request $request)
    {
        if($request->IncomeType == 0)
        {
            $this->SaveOtherIncome($request);
        }
        else if($request->IncomeType == 1)
        {
            $this->SaveMoreIncome($request);
        }

        return response()->json($this->Results);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->Id;
            $income = Income::find($id);
            $income->IncomeDate = date_create($request->IncomeDate);
            if($request->CustomerId != '')
            {
                $income->CustomerId = $request->CustomerId;
            }
            $income->TotalAmount = $request->TotalAmount;
            $income->IncomeType = $request->IncomeType;
            $income->Description = $request->Description;
            $income->DateCreated = date('Y-m-d H:i:s');
            $income->save();
            DB::commit();
        } catch (\Exception $e) {
            $this->SetError(true);
            $this->SetMessage($e);
            DB::rollBack();
        }


        return response()->json($this->Results);
    }

    private function SaveOtherIncome($request)
    {
        $income = new Income();
        $income->IncomeDate = date_create($request->IncomeDate);
        $income->TotalAmount = $request->TotalAmount;
        $income->IncomeType = $request->IncomeType;
        $income->Description = $request->Description;
        $income->DateCreated = date('Y-m-d H:i:s');
        $income->save();
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $income = Income::find($id);
            $rowAffect = $income->delete();
            if($rowAffect == 0)
            {
                $this->Results['IsError'] = true;
                $this->SetMessage('ការលុប​ទិន្នន័យមានបញ្ហាសូមព្យា​យាម​ម្តងទៀត');
            }else{
                if($income->IncomeType == 1)
                {
                    $this->ResetPayment($income->SaleId, $income->TotalAmount);
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

    private function SaveMoreIncome($request)
    {
        $saleIds = $request->SaleIds;
        $sales = Sale::whereIn('Id', $saleIds)->get();
        foreach ($sales as $index => $sale) {
            $income = new Income();
            $income->SaleId = $sale->Id;
            $payAmount = $sale->SubTotal - $sale->PayAmount;
            $income->CustomerId = $request->CustomerId;
            $income->IncomeDate = date_create($request->IncomeDate);
            $income->TotalAmount = $payAmount;
            $income->IncomeType = 1;
            $income->Description = 'លក់ '.$sale->item->ItemName.' ​ទៅអោយអតិថិជនឈ្មោះ ['.$sale->customer->CustomerName.']';
            $income->DateCreated = date('Y-m-d H:i:s');
            $income->save();
            $this->UpdatePayAmount($sale->Id, $sale->SubTotal);
        }
    }

    private function UpdatePayAmount($saleId, $payAmount)
    {
        $sale = Sale::find($saleId);
        $sale->PayAmount = $payAmount;
        $sale->save();
    }

    private function ResetPayment($saleId, $payAmount)
    {
        $sale = Sale::find($saleId);
        $sale->PayAmount = ($sale->PayAmount - $payAmount);
        $sale->save();
    }
}
