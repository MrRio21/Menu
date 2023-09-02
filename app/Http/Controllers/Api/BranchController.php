<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branch = branch::all();
        return response()->json([
            'data' => $branch
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        try {
            $branch = branch::create([
            'name'=>$request['name'],
            'address'=>$request['address'],
            'longitude'=>$request['longitude'],
            'latitude'=>$request['latitude'],
            'open24'=>$request['open24'],
            'open_to'=>$request['open_to'],
            'open_from'=>$request['open_from'],
        ]);
        return response()->json([
            'message'=>'success',
            'data'=>$branch
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(BranchRequest $request,  $id)
    {
         $updateBranch = branch::find($id);
        if ($updateBranch == null){
            return Response(['message'=>'No Bill Found']);
            }else{
                    $updateBranch -> name=$request['name'];
                    $updateBranch -> address= $request['address'];
                    $updateBranch -> longitude =$request['longitude'];
                    $updateBranch -> latitude = $request['latitude'];
                    $updateBranch -> open24 = $request['open24'];
                    $updateBranch -> open_from = $request['open_from'];
                    $updateBranch -> open_to = $request['open_to'];
                    $updateBranch -> save();
                    return response()->json([
                        "success" =>"Data Updated Successfully",
                        'data'=>$updateBranch
                    ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\branch  $branch
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
    {
            $deleteBranch = branch::find($id);
            if ($deleteBranch instanceof branch) {
                if ($deleteBranch->delete()) {
                    return response()->json(['message' => 'branch deleted successfully']);
                } else {
                    return response()->json(['message' => 'Failed to delete branch'], 500);
                }
            } else {
                return response()->json(['message' => 'branch not found'], 404);
            }

    }
}
