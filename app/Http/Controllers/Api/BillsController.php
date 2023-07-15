<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillsRequest;
use App\Models\Bills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allBills =Bills::all();
        return response()->json([
            'data'=>$allBills
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillsRequest $request)  {
        try {

            $bills = Bills::create([
                'customer_name'=>$request['customer_name'],
                'customer_address'=>$request['customer_address'],
                'customer_phone'=>$request['customer_phone'],
                'order_details'=>$request['order_details'],
                'bill_total'=>$request['bill_total'],
            ]);

            return response()->json([
                'data'=>$bills, 201
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function update(BillsRequest $request, $id)
    {

        $updateBill = Bills::find($id);
        if ($updateBill == null){
            return Response(['message'=>'No Bill Found']);
            }else{
                    $updateBill -> customer_name=$request['customer_name'];
                    $updateBill -> customer_address= $request['customer_address'];
                    $updateBill -> order_details =$request['order_details'];
                    $updateBill -> bill_total = $request['bill_total'];
                    $updateBill -> customer_phone = $request['customer_phone'];
                    $updateBill -> save();
                    return response()->json([
                        "success" =>"Data Updated Successfully",
                        'data'=>$updateBill
                    ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bills  $bills
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $deleteBills = Bills::find($id);
            if ($deleteBills instanceof Bills) {
                if ($deleteBills->delete()) {
                    return response()->json(['message' => 'Bills deleted successfully']);
                } else {
                    return response()->json(['message' => 'Failed to delete Bills'], 500);
                }
            } else {
                return response()->json(['message' => 'Bills not found'], 404);
            }

    }
}
