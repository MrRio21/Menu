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
//     public function update(ProviderRequest $request, $id)
//     {
//         $img=md5(microtime()).$request->image->getClientOriginalName();
//         $request->image->storeAs("public/imgs",$img);

//         if ($request->hasFile('image')) {
//         $img = md5(microtime()) . $request->image->getClientOriginalName();
//         $request->image->storeAs("public/imgs", $img);
//     } else {
//         $img=md5(microtime()).$request->image->getClientOriginalName();
//         $request->image->storeAs("public/imgs",$img);
//     }
//     if($id != 0) {
//         $editProvider = Provider::find($id);
//         // if ($editProvider) {
//             $editProvider->name = $request->input('name');
//             $editProvider->eng_name = $request->input('eng_name');
//             $editProvider->service_type = $request->input('service_type');
//             $editProvider->whatsapp = $request->input('whatsapp');
//             $editProvider->phone = $request->input('phone');
//             $editProvider->address = $request->input('address');
//             $editProvider->en_address = $request->input('en_address');
//             $editProvider->instagram = $request->input('instagram');
//             $editProvider->facebook = $request->input('facebook');
//             $editProvider->theme = $request->input('theme');
//             $editProvider->twitter = $request->input('twitter');
//             $editProvider->is_active = $request->input('is_active');
//             $editProvider->opened_to = $request->input('opened_to');
//             $editProvider->opened_from = $request->input('opened_from');
//             $editProvider->url = $request->input('url');
//             $editProvider->tables = $request->input('tables');
//             if ($img !== null) {
//                 $editProvider->image = $img; // Use the existing $img variable
//             }
//             $editProvider->save();
//         }

//         else{
//         $editProvider = Provider::Create([
//         'name'=>$request['name'],
//         'eng_name'=>$request['eng_name'],
//         'image'=>$img,
//         'service_type'=>$request['service_type'],
//         'whatsapp'=>$request['whatsapp'],
//         'phone'=>$request['phone'],
//         'address'=>$request['address'],
//         'en_address'=>$request['en_address'],
//         'instagram'=>$request['instagram'],
//         'facebook'=>$request['facebook'],
//         'twitter'=>$request['twitter'],
//         'theme'=>$request['theme'],
//         'opened_from'=>$request['opened_from'],
//         'opened_to'=>$request['opened_to'],
//         'is_active'=>$request['is_active'],
//         'url'=>$request['url'],
//         'tables'=>$request['tables'],
//     ]);
// }
//         return response()->json([
//             'data'=>$editProvider
//         ]);
//     }


    public function update(ProviderRequest $request, $id)
    {
        // Validate the incoming data using the ProviderRequest class
        $validatedData = $request->validated();

        // Handle image upload
        $img = null; // Default image value
        if ($request->hasFile('image')) {
            $img = md5(microtime()) . $request->image->getClientOriginalName();
            $request->image->storeAs("public/imgs", $img);
        }

        // Find the provider by ID
        $editProvider = Provider::find($id);

        if ($editProvider) {
            // Update the existing provider attributes
            $editProvider->update(array_merge($validatedData,
                ['image' => $img ,
                    'address' =>$request['address'],
                    'en_address' =>$request['en_address'],
                    'instagram' =>$request['instagram'],
                    'facebook' =>$request['facebook'],
                    'theme' =>$request['theme'],
                    'twitter' =>$request['twitter'],
                    'is_active' =>$request['is_active'],
                    'opened_to' =>$request['opened_to'],
                    'opened_from' =>$request['opened_from'],
                    'url' =>$request['url'],
                    'tables' =>$request['tables'],
                ]
        ));
        } else {
            // Create a new provider
            $editProvider = Provider::create(array_merge( $validatedData,
                ['image' => $img,
                    'address' =>$request['address'],
                    'en_address' =>$request['en_address'],
                    'instagram' =>$request['instagram'],
                    'facebook' =>$request['facebook'],
                    'theme' =>$request['theme'],
                    'twitter' =>$request['twitter'],
                    'is_active' =>$request['is_active'],
                    'opened_to' =>$request['opened_to'],
                    'opened_from' =>$request['opened_from'],
                    'url' =>$request['url'],
                    'tables' =>$request['tables'],
                ]
            ));
        }

        return response()->json([
            'message' => $editProvider ? 'Provider updated or created successfully' : 'Provider not found',
            'data' => $editProvider
        ], $editProvider ? 200 : 404); // Return appropriate HTTP status codes
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
