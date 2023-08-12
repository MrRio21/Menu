<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProviderRequest;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allProvider =Provider::all();
        return response()->json([
            'data'=>$allProvider
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProviderRequest $request){
        $img=md5(microtime()).$request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs",$img);
        $provider = Provider::create([
            'name'=>$request['name'],
            'eng_name'=>$request['eng_name'],
            'image'=>$img,
            'service_type'=>$request['service_type'],
            'whatsapp'=>$request['whatsapp'],
            'phone'=>$request['phone'],
            'address'=>$request['address'],
            'en_address'=>$request['en_address'],
            'instagram'=>$request['instagram'],
            'facebook'=>$request['facebook'],
            'twitter'=>$request['twitter'],
            'theme'=>$request['theme'],
            'opened_from'=>$request['opened_from'],
            'opened_to'=>$request['opened_to'],
            'is_active'=>$request['is_active'],
            'url'=>$request['url'],
            'tables'=>$request['tables'],
        ]);

        return response()->json([
            'data'=>$provider
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProviderRequest $request, $id)
    {
        $img=md5(microtime()).$request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs",$img);
        $editProvider = Provider::updateOrCreate([
            'name'=>$request['name'],
            'eng_name'=>$request['eng_name'],
            'image'=>$img,
            'service_type'=>$request['service_type'],
            'whatsapp'=>$request['whatsapp'],
            'phone'=>$request['phone'],
            'address'=>$request['address'],
            'en_address'=>$request['en_address'],
            'instagram'=>$request['instagram'],
            'facebook'=>$request['facebook'],
            'twitter'=>$request['twitter'],
            'theme'=>$request['theme'],
            'opened_from'=>$request['opened_from'],
            'opened_to'=>$request['opened_to'],
            'is_active'=>$request['is_active'],
            'url'=>$request['url'],
            'tables'=>$request['tables'],
        ]);
        return response()->json([
            'data'=>$editProvider
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
        {
            $deleteProvider = Provider::find($id);
            if ($deleteProvider instanceof Provider) {
                if ($deleteProvider->delete()) {
                    return response()->json(['message' => 'Provider deleted successfully']);
                } else {
                    return response()->json(['message' => 'Failed to delete Provider'], 500);
                }
            } else {
                return response()->json(['message' => 'Provider not found'], 404);
            }
        }
}
