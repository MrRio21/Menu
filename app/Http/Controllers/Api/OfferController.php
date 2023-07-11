<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offer = Offer::all();
        return response()->json([
            'data'=>$offer
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:4'],
            'en_name' => ['required', 'string', 'min:4'],
            'details' => ['required', 'string', 'min:4'],
            'en_details' => ['required', 'string', 'min:4'],
            'price' => ['required', 'numeric'],
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $img=md5(microtime()).$request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs",$img);
        try {
            $offer = Offer::create([
                "name"      =>   $request['name'],
                "en_name"     =>    $request["en_name"],
                "details"=>       $request["details"],
                "en_details"=>        $request["en_details"],
                "price"=>         $request["price"]?? null,
                "is_active"      =>   $request['is_active'],
                'image'=>$img,
            ]);
            return response()->json([
                'date'=>$offer
            ]);
        } catch (\Throwable $th) {
            return response()->json([
            'error' => $th->getMessage(),
        ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $updateOffer = Offer::find($id);
    if ($request->hasFile('image')) {
        Storage::delete("/storage/imgs/$updateOffer->image");
        $img=md5(microtime()).$request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs", $img);
        $data=$request->all(['name','en_name', 'details',"en_details" ,"is_active",'price']);
        $data['image']="$img";

        return response()->json([
            'updated offer with image successfully!' ,
            'data'=>$data
        ]);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Offer  $offer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $deleteOffer = Offer::find($id);
            if ($deleteOffer instanceof Offer) {
                if ($deleteOffer->delete()) {
                    return response()->json(['message' => 'Offer deleted successfully']);
                } else {
                    return response()->json(['message' => 'Failed to delete Offer'], 500);
                }
            } else {
                return response()->json(['message' => 'Offer not found'], 404);
            }
    }
}
