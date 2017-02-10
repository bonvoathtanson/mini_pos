<?php

namespace App\Http\Controllers;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\SystemConfig;
use PDF;

class ItemController extends Controller
{
    public function index()
    {
        return view('items.index');
    }

    public function search(){
        $items = Item::all();
        $alertstock = SystemConfig::where('Id', '=', 1)->first();
        $data = array(
            'items' => $items,
            'stock' => $alertstock
        );
        $this->SetData($data);

        return response()->json($this->Results);
    }

    public function create()
    {
        return view('items.create');
    }

    public function report()
    {
        $items = Item::all();
        return view('reports.item', ['items' => $items]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Item::rules());
        if($validator->fails())
        {
            $this->Fail();
            $this->SetMessage($validator->messages()->first());
        }else{
            $item = new Item();
            $item['ItemCode'] = $request['itemcode'];
            $item->ItemName = $request->itemname;
            $item->SalePrice = $request->price;
            $item->UnitInStock = $request->quantity;
            $item->DateCreated = date('Y-m-d H:i:s');
            $item->save();
        }

        return response()->json($this->Results);
    }

    public function detail($id)
    {
        $item = Item::where('ItemCode', '=', $id)->first();
        $this->SetData($item);

        return response()->json($this->Results);
    }

    public function stock(Request $request)
    {
        $systemconfig = SystemConfig::where('Id', '=', 1)->first();
        if($systemconfig != null){
            $systemconfig->Value = $request->stock;
            $systemconfig->save();
        }else{
            $stock = new SystemConfig();
            $stock->Id = 1;
            $stock->Name = "Alert Stock Confirm";
            $stock->Value = $request->stock;
            $stock->save();
        }

        return response()->json($this->Results);
    }

    public function edit($id)
    {
        $item = Item::find($id);

        return view('items.edit', ['item' => $item]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $item = Item::find($id);
        $item->ItemName = $request->itemname;
        $item->SalePrice = $request->price;
        $item->UnitInStock = $request->quantity;
        $item->LastUpdated = date('Y-m-d H:i:s');
        $item->save();

        return response()->json($this->Results);
    }

    public function destroy($id)
    {
        $rowAffect = Item::find($id)->delete();
        if($rowAffect == 0)
        {
            $this->Results['IsError'] = true;
            $this->SetMessage('ការលុប​ទិន្នន័យមានបញ្ហាសូមព្យា​យាម​ម្តងទៀត');
        }

        return response()->json($this->Results);
    }
}
