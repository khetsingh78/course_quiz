<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::latest()->get();
        return view('admin.category.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {

            $request->validate([
                "name" => 'required',
                "category_type" => 'required',
                "cover_image" => 'required|mimes:jpeg,png,jpg,svg'
            ]);

            $coverimageurl = $request->file("cover_image")->store("category", 'public');
            $coverimageurl = $coverimageurl;

            $category = Category::create([
                'name' => trim($request->name),
                'slug' => Str::slug(trim($request->name), '-'),
                'description' =>  trim($request->description ?? null),
                'type' =>  trim($request->category_type),
                'cover_image' =>  $coverimageurl,
            ]);

            return response()->json([
                'success' => true,
                "message" => 'Created successfully.',
                "data" => $category
            ]);
        } catch (\Throwable $th) {
            Log::info("add category" . $th);
            return response()->json([
                'success' => false,
                "message" => 'Something went wrong.',
                "error" => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {

        try {

            $request->validate([
                "name" => 'required',
                "type" => 'required',
            ]);

            if ($request->hasFile('cover_image')) {
                // $previous_img = explode($request->getSchemeAndHttpHost(), $category->cover_image)[1];
                $previous_img = $category->cover_image;
                if ($category->cover_image && Storage::disk('public')->exists($previous_img)) {
                    Storage::disk('public')->delete($previous_img);
                }
                $coverimageurl = $request->file('cover_image')->store('category', 'public');
                $coverimageurl = $coverimageurl;
                $category->cover_image = $coverimageurl;
            }

            $category->update([
                'name'       => $request->name,
                'slug'        => Str::slug($request->name),
                'type'        => $request->type,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("Edit category" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category)
    {

        try {

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("Edit category" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
