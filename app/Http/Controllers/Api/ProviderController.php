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
            'image'=>$img,
            'whatsapp'=>$request['whatsapp'],
            'phone'=>$request['phone'],
            'discount'=>$request['discount'],
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
    // Validate the incoming data using the ProviderRequest class
    $validatedData = $request->validated();

    // Find the provider by ID
    $editProvider = Provider::find($id);

    if (!$editProvider) {
        // Create a new provider if it doesn't exist
        $editProvider = new Provider();
    }

    // Handle image upload if a new file is provided
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($editProvider->image) {
            // Delete the old image file from storage here
            // For example: Storage::delete('public/imgs/' . $editProvider->image);
        }

        // Upload the new image
        $img = md5(microtime()) . $request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs", $img);

        // Update or set the new image value
        $editProvider->image = $img;
    }

    // Update or set the provider attributes
    $editProvider->fill(array_merge($validatedData, [
        'address' => $request['address'],
        'instagram' => $request['instagram'],
        'facebook' => $request['facebook'],
        'theme' => $request['theme'],
        'twitter' => $request['twitter'],
        'is_active' => $request['is_active'],
        'opened_to' => $request['opened_to'],
        'opened_from' => $request['opened_from'],
        'url' => $request['url'],
        'tables' => $request['tables'],
        'discount' => $request['discount'],
        'snapchat' => $request['snapchat'],
        'tiktok' => $request['tiktok'],
        'google_map_link' => $request['google_map_link'],
        'latitude' => $request['latitude'],
        'longitude' => $request['longitude'],
        // Include other fields and attributes here
    ]));

    // Save the provider data
    $editProvider->save();

    return response()->json([
        'message' => 'Provider updated or created successfully',
        'data' => $editProvider
    ], 200);
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
