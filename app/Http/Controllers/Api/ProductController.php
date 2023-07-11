<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOption2;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allCategory =Category::all();
        return response()->json([
            'data'=>$allCategory
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
        'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'details' => ['required', 'string'],
        'en_details' => ['required', 'string'],
        'price' => 'required',
        'is_active' => ['required'],
        'position' => ['required', 'string'],
    ]);

    try {
        $img=md5(microtime()).$request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs", $img);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Failed to upload image',
        ], 500);
    }

    $product = Product::create([
        'name'=>$request['name'],
        'en_name'=>$request['en_name'],
        'price'=>$request['price'],
        'details'=>$request['details'],
        'en_details'=>$request['en_details'],
        'is_active'=>$request['is_active'],
        'position'=>$request['position'],
        'image'=>$img,
        'provider_id'=>$request['provider_id'],
        'category_id'=>$request['category_id'],
    ]);

    // add option in ProductOption
    $options = $request->input('option', []);
    foreach ($options as $option) {
        ProductOption::create([
            'option' => $option,
            'product_id' => $product->id,
        ]);
    }
    // add option 1 in ProductOption 2
    $option_1 = $request->input('option_1', []);
    foreach ($option_1 as $option) {
        ProductOption2::create([
            'option_1' => $option,
            'product_id' => $product->id,
        ]);
    }

        return response()->json([
            'data' => $product,
            'option' => $options,
            'option_1' => $option_1,
        ]);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    $request->validate([
      'name' => ['required', 'string', 'min:4'],
      'en_name' => ['required', 'string', 'min:4'],
      'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'details' => ['required', 'string'],
      'en_details' => ['required', 'string'],
      'price' => 'required',
      'is_active' => ['required'],
      'position' => ['required', 'string'],
        ]);
    $img=md5(microtime()).$request->image->getClientOriginalName();
    $request->image->storeAs("public/imgs", $img);
    $updateProduct = Product::find($id);
    $updateProduct->name = $request->input('name');
    $updateProduct->en_name = $request->input('en_name');
    $updateProduct->details = $request->input('details');
    $updateProduct->en_details = $request->input('en_details');
    $updateProduct->en_details = $request->input('en_details');
    $updateProduct->price = $request->input('price');
    $updateProduct->is_active = $request->input('is_active');
    $updateProduct->position = $request->input('position');
    $img=md5(microtime()).$request->image->getClientOriginalName();
    $request->image->storeAs("public/imgs", $img);

    $updateProduct->save();
    // Delete existing options
    $updateProduct->productOptions()->delete();
    $updateProduct->productOptions2()->delete();

    // Add new options
    $options = $request->input('option', []);
    foreach ($options as $option) {
        ProductOption::create([
            'option' => $option,
            'product_id' => $updateProduct->id,
        ]);
    }

    $option_1 = $request->input('option_1', []);
    foreach ($option_1 as $option) {
        ProductOption2::create([
            'option_1' => $option,
            'product_id' => $updateProduct->id,
        ]);
        return response()->json([
            'data'=>$updateProduct,
            'option' => $options,
            'option_1' => $option_1,
        ]);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteProduct = Product::find($id);
            if ($deleteProduct instanceof Product) {
                $deleteProduct->productOptions()->delete();
                $deleteProduct->productOptions2()->delete();
                if ($deleteProduct->delete()) {
                    return response()->json(['message' => 'Product deleted successfully']);
                } else {
                    return response()->json(['message' => 'Failed to delete Product'], 500);
                }
            } else {
                return response()->json(['message' => 'Product not found'], 404);
            }
    }

}

