<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\Customer;
use App\Models\CustomerAsk;
use Illuminate\Http\Request;
use App\Http\Requests;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customers/index');
    }

    public function create()
    {
        return view('customers/create');
    }

    public function askinfo()
    {
        return view('customers.info');
    }

    public function editinfo($id)
    {
        $customerask = CustomerAsk::find($id);
        $customer = Customer::where('Id', '=', $customerask->CustomerId)->first();
        return view('customers.editinfo', ['customer' => $customer,'customerask' => $customerask]);
    }
    public function updateinfo(Request $request)
    {

        $validator = Validator::make($request->all(), CustomerAsk::rules());
        if($validator->fails())
        {
            $this->Fail();
            $this->SetMessage($validator->messages()->first());
        }else{

            $id = $request->customerAskId;
            $customerask = CustomerAsk::find($id);
            $customerask->AskDate = $request->AskDate;
            $customerask->ConfirmDate = $request->ConfirmDate;
            $customerask->Description = $request->Description;
            $customerask->Reason = $request->Reason;
            $customerask->StatusId = $request->StatusId;
            $customerask->save();

        }

        return response()->json($this->Results);
    }
    public function indexinfo(Request $request)
    {
          $customerId = $request->customerId;
          $statusType = $request->statusTypeId;
        if( $customerId !='' || $statusType !='' ){

            $query = CustomerAsk::query();

            if(!empty($customerId)){
                $query->where('CustomerId', '=', $customerId);
            }
            if(!empty($statusType)){
                $query->where('StatusId', '=', $statusType);
            }

            $customers = $query->orderBy('AskDate','ASC')->get();

        }else{
            $customers = CustomerAsk::where('StatusId', '=', CustomerAsk::WAITING)
            ->orderBy('AskDate','ASC')
            ->get();
        }
            $customers->load('Customer');
            $this->SetData($customers);

        return response()->json($this->Results);
    }

    public function addinfo($id)
    {

        $customer = Customer::find($id);

        return view('customers.addinfo', ['customer' => $customer]);

    }

    public function insertinfo(Request $request)
    {
        $validator = Validator::make($request->all(), CustomerAsk::rules());
        if($validator->fails())
        {
            $this->Fail();
            $this->SetMessage($validator->messages()->first());
        }else{
            $customerask = new CustomerAsk();
            $customerask->CustomerId = $request->CustomerId;
            $customerask->AskDate = $request->AskDate;
            $customerask->ConfirmDate = $request->ConfirmDate;
            $customerask->Description = $request->Description;
            $customerask->Reason = $request->Reason;
            $customerask->StatusId = $request->StatusId;
            $customerask->save();
        }

        return response()->json($this->Results);
    }

    public function search()
    {
        $customers = Customer::where('TypeId', '<>', Customer::CLOSE)->get();
        $this->SetData($customers);

        return response()->json($this->Results);
    }

    public function filter($keyword='')
    {
        $key = "%$keyword%";
        $customers = Customer::where('CustomerCode', 'Like', $key)
                            ->orwhere('CustomerName', 'Like', $key)
                            ->orwhere('PhoneNumber', 'Like', $key)
                            ->get();
        $this->SetData($customers);

        return response()->json($this->Results);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Customer::rules());
        if($validator->fails())
        {
            $this->Fail();
            $this->SetMessage($validator->messages()->first());
        }else{
            $customer = new Customer();
            $customer->CustomerCode = $request->CustomerCode;
            $customer->CustomerName = $request->CustomerName;
            $customer->Sex = $request->Sex;
            $customer->PhoneNumber = $request->PhoneNumber;
            $customer->Address = $request->Address;
            $customer->TypeId = $request->TypeId;
            $customer->DateCreated = date('Y-m-d H:i:s');
            $customer->save();
            $this->SetData($customer);
        }

        return response()->json($this->Results);
    }

    public function edit($id)
    {
        $customer = Customer::find($id);

        return view('customers.edit', ['customer' => $customer]);
    }

    public function update(Request $request)
    {
        $id = $request->Id;
        $customer = Customer::find($id);
        $customer->CustomerName = $request->CustomerName;
        $customer->Sex = $request->Sex;
        $customer->PhoneNumber = $request->PhoneNumber;
        $customer->Address = $request->Address;
        $customer->TypeId = $request->TypeId;
        $customer->LastUpdated = date('Y-m-d H:i:s');
        $customer->save();

        return response()->json($this->Results);
    }

    public function destroy($id)
    {
        $rowaffect = Customer::find($id)->delete();
        if($rowaffect == 0){
            $this->SetError(true);
            $this->SetMessage('ការលុប​ទិន្នន័យមានបញ្ហាសូមព្យា​យាម​ម្តងទៀត');
        }

        return response()->json($this->Results);
    }
}
