<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\InOutRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ArrayResource;
use App\Models\Suppliers;
use App\Models\SupplierGood;
use App\Models\MaterialIn;
use App\Models\MaterialOut;
use App\Models\Po;
use App\Models\PoList;
use PDF;

class WarehouseController extends Controller
{
    public function getStock(Request $request)
    {
        if ($request->search) return ArrayResource::collection(
            SupplierGood::select('supplier_goods.name', 
            DB::raw('IFNULL(SUM(material_ins.qty),0) - IFNULL((SELECT SUM(material_outs.qty) AS outgoing FROM material_outs WHERE id_materials = material_ins.id_materials),0) AS stock '))
            ->leftJoin('material_ins', 'supplier_goods.id', '=', 'material_ins.id_materials')
            ->join('suppliers', 'suppliers.id','=','supplier_goods.supplier_id')
            ->where("supplier_goods.name", 'like', '%' . $request->search . '%')
            ->where("suppliers.id", $request->supplier_id)
            ->groupBy("supplier_goods.id")
            ->get()
        );
        if (!$request->search) return ArrayResource::collection(
            SupplierGood::select('supplier_goods.name', 
            DB::raw('IFNULL(SUM(material_ins.qty),0) - IFNULL((SELECT SUM(material_outs.qty) AS outgoing FROM material_outs WHERE id_materials = material_ins.id_materials),0) AS stock '))
            ->leftJoin('material_ins', 'supplier_goods.id', '=', 'material_ins.id_materials')
            ->join('suppliers', 'suppliers.id','=','supplier_goods.supplier_id')
            ->where("suppliers.id", $request->supplier_id)
            ->groupBy("supplier_goods.id")
            ->get()
        );
    }

    public function getIncoming(Request $request)
    {
        if ($request->search) return ArrayResource::collection(
            MaterialIn::select('material_ins.id','supplier_goods.name', 'qty', 'date', 'remark')
            ->join('supplier_goods', 'supplier_goods.id', '=', 'material_ins.id_materials')
            ->join('suppliers', 'suppliers.id','=','supplier_goods.supplier_id')
            ->where("supplier_goods.name", 'like', '%' . $request->search . '%')
            ->where("suppliers.id", $request->supplier_id)
            ->get()
        );
        if (!$request->search) return ArrayResource::collection(
            MaterialIn::select('material_ins.id','supplier_goods.name', 'qty', 'date', 'remark')
            ->join('supplier_goods', 'supplier_goods.id', '=', 'material_ins.id_materials')
            ->join('suppliers', 'suppliers.id','=','supplier_goods.supplier_id')
            ->where("suppliers.id", $request->supplier_id)
            ->get()
        );
    }

    public function getOutgoing(Request $request)
    {
        if ($request->search) return ArrayResource::collection(
            MaterialOut::select('material_outs.id','supplier_goods.name', 'qty', 'date', 'remark')
            ->join('supplier_goods', 'supplier_goods.id', '=', 'material_outs.id_materials')
            ->join('suppliers', 'suppliers.id','=','supplier_goods.supplier_id')
            ->where("supplier_goods.name", 'like', '%' . $request->search . '%')
            ->where("suppliers.id", $request->supplier_id)
            ->get()
        );
        if (!$request->search) return ArrayResource::collection(
            MaterialOut::select('material_outs.id','supplier_goods.name', 'qty', 'date', 'remark')
            ->join('supplier_goods', 'supplier_goods.id', '=', 'material_outs.id_materials')
            ->join('suppliers', 'suppliers.id','=','supplier_goods.supplier_id')
            ->where("suppliers.id", $request->supplier_id)
            ->get()
        );
    }

    public function getPo(Request $request) 
    {
        if ($request->search) return ArrayResource::collection(
            Po::select('pos.id', 'pos.code as po_code', 'suppliers.name as suplier_name', 'pos.terms')
                ->join('po_lists', 'po_lists.id_po', '=', 'pos.id')
                ->join('supplier_goods', 'po_lists.id_supplier_good', '=', 'supplier_goods.id')
                ->join('suppliers', 'supplier_goods.supplier_id', '=', 'suppliers.id')
                ->where("suppliers.name", 'like', '%' . $request->search . '%')
                ->orWhere("pos.code", 'like', '%' . $request->search . '%')
                ->groupBy('suppliers.id', 'pos.code', 'pos.id')
                ->get()
        );

        if (!$request->search) return ArrayResource::collection(
            Po::select('pos.id', 'pos.code as po_code', 'suppliers.name as suplier_name', 'pos.terms')
                ->join('po_lists', 'po_lists.id_po', '=', 'pos.id')
                ->join('supplier_goods', 'po_lists.id_supplier_good', '=', 'supplier_goods.id')
                ->join('suppliers', 'supplier_goods.supplier_id', '=', 'suppliers.id')
                ->groupBy('suppliers.id', 'pos.code', 'pos.id')
                ->get()
        );
        
    }

    public function getPoDetail($id) 
    {
        return ArrayResource::collection(
            PoList::select('supplier_goods.name', 'po_lists.qty', 'po_lists.delivery_date', 'supplier_goods.price', 'suppliers.currency')
                ->join('supplier_goods', 'po_lists.id_supplier_good', '=', 'supplier_goods.id')
                ->join('suppliers', 'supplier_goods.supplier_id', '=', 'suppliers.id')
                ->where("po_lists.id_po", '=', $id)
                ->get()
        );
    }

    public function addPo(Request $request)
    {
        $num = Po::latest('num')->value('num');
        $code = str_pad($num+1, 4, '0', STR_PAD_LEFT);
        $po = Po::insert(["code"=>'SDI-'.$code, "num"=>$num+1, "terms"=>$request->terms]);
        $id = Po::latest('id')->value('id');

        foreach ($request->data as $key => $value) {
            $poList = PoList::insert(["id_po"=>$id, "id_supplier_good"=>$value['material'], "qty"=>$value['qty'], "delivery_date"=>$value['date']]);
        }        

        return response()->noContent();
    }

    public function deletePo($id) {
        $data = Po::find($id);
        if($data->delete())
            PoList::where('id_po', $id)->delete();
        else
            return response()->json(error);
        return response()->json(null); 
    }

    public function addIncoming(InOutRequest $request)
    {
        $data = MaterialIn::create($request->validated());

        return new ArrayResource($data);
    }

    public function addOutgoing(InOutRequest $request)
    {
        $data = MaterialOut::create($request->validated());

        return new ArrayResource($data);
    }

    public function deleteIncoming($id) {
        $data = MaterialIn::findOrFail($id);
        if($data)
           $data->delete(); 
        else
            return response()->json(error);
        return response()->json(null); 
    }

    public function deleteOutgoing($id) {
        $data = MaterialOut::findOrFail($id);
        if($data)
           $data->delete(); 
        else
            return response()->json(error);
        return response()->json(null); 
    }

    public function generatePDF($id)
    {
  
        $po = Po::select('pos.id', 'pos.code', 'suppliers.name', 'suppliers.address', 'pos.terms', 'suppliers.currency')
                ->join('po_lists', 'po_lists.id_po', '=', 'pos.id')
                ->join('supplier_goods', 'po_lists.id_supplier_good', '=', 'supplier_goods.id')
                ->join('suppliers', 'supplier_goods.supplier_id', '=', 'suppliers.id')
                ->where('pos.id', $id)
                ->groupBy('suppliers.id', 'pos.code', 'pos.id')
                ->get();

        $material = PoList::select('supplier_goods.name', 'po_lists.qty', 'po_lists.delivery_date', 'supplier_goods.price', 'supplier_goods.unit')
                ->join('supplier_goods', 'po_lists.id_supplier_good', '=', 'supplier_goods.id')
                ->where("po_lists.id_po", '=', $id)
                ->get();

        $data = [
            'date' => date('d/m/y'),
            'po' => $po,
            'datas' => $material,
        ]; 

        // return view('myPDF', ['data' => $data]);
        $pdf = PDF::loadView('myPDF', ['data' => $data])->setPaper('a4', 'potrait');
        return $pdf->download('PO-'.$po[0]['code'].'.pdf');
    }
}
