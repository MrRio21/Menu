<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOption2;
use App\Models\promotionalOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allProduct = Product::all();
        return response()->json([
            'data' => $allProduct
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {

        try {
            $img = md5(microtime()).$request->image->getClientOriginalName();
            $request->image->storeAs("public/imgs", $img);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to upload image',
            ], 500);
        }

        $product = Product::create([
            'name' => $request['name'],
            'price' => $request['price'],
            'details' => $request['details'],
            'is_active' => $request['is_active'],
            'position' => $request['position'],
            'calories' => $request['calories'],
            'image' => $img,
            'category_id' => $request['category_id'],
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
    public function update(ProductRequest $request, $id)
    {
        $img = md5(microtime()).$request->image->getClientOriginalName();
        $request->image->storeAs("public/imgs", $img);
        $updateProduct = Product::find($id);
        $updateProduct->name = $request->input('name');
        $updateProduct->details = $request->input('details');
        $updateProduct->price = $request->input('price');
        $updateProduct->is_active = $request->input('is_active');
        $updateProduct->position = $request->input('position');
        $img = md5(microtime()).$request->image->getClientOriginalName();
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
                'data' => $updateProduct,
                'option' => $options,
                'option_1' => $option_1,
            ]);
        }
    }


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


    /////////////promotionalOffer
    public function promotionalOffer1(Request $request)
    {
        $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

        // Get the uploaded image file
        $image = $request->file('image');

        // Check if a cover image already exists
        $coverImage = promotionalOffer::first();

        if ($coverImage) {
            // If a cover image exists, update it with the new image
            $coverImageName = $coverImage->image;

            // Delete the old image file
            Storage::delete("public/imgs/$coverImageName");

            // Store the new image file
            $imageName = md5(microtime()) . $image->getClientOriginalName();
            $image->storeAs('public/imgs', $imageName);

            // Update the cover image record in the database
            $coverImage->update([
                'image' => $imageName
            ]);
        } else {
            // If no cover image exists, create a new one
            $imageName = md5(microtime()) . $image->getClientOriginalName();
            $image->storeAs('public/imgs', $imageName);

            // Create a new cover image record in the database
            promotionalOffer::create([
                'image' => $imageName
            ]);
        }
        return back();
    }



    // public function promotionalOffer(Request $request, $id)
    // {
    //     // Find the promotionalOffer by its ID
    //     $promotionalOffer = promotionalOffer::find($id);

    //     $image = $request->file('coverImage');

    //     if ($promotionalOffer) {
    //         // Delete the old image if it exists
    //         if (Storage::disk('public')->exists('images/' . $promotionalOffer->image)) {
    //             Storage::disk('public')->delete('images/' . $promotionalOffer->image);
    //         }

    //         // Upload and store the new image
    //         $imagePath = md5(microtime()) . $image->getClientOriginalName();
    //         $image->storeAs('public/imgs', $imagePath);

    //         // Update the 'image' and 'is_active' attributes in the database
    //         $promotionalOffer->update([
    //             'image' => $imagePath,
    //             'is_active' => $request->input('is_active'), // Assuming you receive 'is_active' in the request
    //         ]);

    //         // Optionally, you can update other attributes or perform additional actions.

    //         return response()->json(['message' => 'Promotional offer updated successfully',
    //         'data'=>$promotionalOffer]
    //         , 200);
    //     }

    //     return response()->json(['error' => 'Promotional offer not found'], 404);
    // }


    public function promotionalOffer(Request $request, $id)
{
    $image = $request->file('image');
    $imagePath = null;
    // dd($id);
    if ($image) {
        // Delete the old image if it exists
        if ($id) {
            $promotionalOffer = PromotionalOffer::find($id);
            if ($promotionalOffer && Storage::disk('public')->exists('images/' . $promotionalOffer->image)) {
                Storage::disk('public')->delete('images/' . $promotionalOffer->image);
            }
        }

        // Upload and store the new image
        $imagePath = md5(microtime()) . $image->getClientOriginalName();
        $image->storeAs('public/imgs', $imagePath);
    }

    // Create or update the promotional offer
    if ($id) {
        $promotionalOffer = PromotionalOffer::find($id);
        if (!$promotionalOffer) {
            return response()->json(['error' => 'Promotional offer not found'], 404);
        }

        $promotionalOffer->update([
            'image' => $imagePath ?: $promotionalOffer->image, // Use the new image if provided, otherwise keep the old image
            'is_active' => $request->input('is_active', $promotionalOffer->is_active), // Use the new value if provided, otherwise keep the old value
            // Update other attributes here as needed
        ]);
    } else {
        $promotionalOffer = PromotionalOffer::create([
            'image' => $imagePath,
            'is_active' => $request->input('is_active', true), // Assuming a default value
            // Set other attributes for a new promotional offer
        ]);
    }

    return response()->json(['message' => 'Promotional offer ' . ($id ? 'updated' : 'created') . ' successfully', 'data' => $promotionalOffer], 200);
}


}



