<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //token
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
    public function store(CategoryRequest $request)
    {
        $img = md5(microtime()) . $request->logo->getClientOriginalName();
        $request->logo->storeAs("public/imgs", $img);
        $category = Category::create([
            'category_name' => $request['category_name'],
            'position' => $request['position'],
            'logo' => $img,
        ]);
        return response()->json([
            'data' => $category
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
        public function update(CategoryRequest $request, $id)
    {
        
        $img=md5(microtime()).$request->logo->getClientOriginalName();
        $request->logo->storeAs("public/imgs",$img);
        $updateCategory = Category::find($id);
        $updateCategory->category_name = $request->input('category_name');
        $updateCategory->position = $request->input('position');
        $img=md5(microtime()).$request->logo->getClientOriginalName();
        $request->logo->storeAs("public/imgs",$img);
        // $updateCategory->image = $img;
        $updateCategory->save();
        return response()->json([
            'data'=>$updateCategory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleteCategory = Category::find($id);
            if ($deleteCategory instanceof Category) {
                if ($deleteCategory->delete()) {
                    return response()->json(['message' => 'Category deleted successfully']);
                } else {
                    return response()->json(['message' => 'Failed to delete Category'], 500);
                }
            } else {
                return response()->json(['message' => 'Category not found'], 404);
            }
    }
}
