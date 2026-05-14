<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banner = Banner::latest()->get();
        return view('admin.banner.index', compact('banner'));
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

        // dd($request->all());
        try {

            $request->validate([
                "title" => 'required',
                "redirect_link" => 'required',
                // "banner_type" => 'required',
                "cover_image" => 'required|mimes:jpeg,png,jpg,svg'
            ]);

            $coverimageurl = $request->file("cover_image")->store("banner", 'public');
            $coverimageurl = $coverimageurl;

            $banner = Banner::create([
                'title' => $request->title,
                'img_url' =>  $coverimageurl,
                'redirect_url' =>  $request->redirect_link,
            ]);

            return response()->json([
                'success' => true,
                "message" => 'Created successfully.',
                "data" => $banner
            ]);
        } catch (\Throwable $th) {
            Log::info($th);
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
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {

        try {

            $request->validate([
                "name" => 'required',
                "type" => 'required',
            ]);

            if ($request->hasFile('cover_image')) {
                $previous_img = $banner->cover_image;
                if ($banner->cover_image && Storage::disk('public')->exists($previous_img)) {
                    Storage::disk('public')->delete($previous_img);
                }
                $coverimageurl = $request->file('cover_image')->store('banner', 'public');
                $coverimageurl = $coverimageurl;
                $banner->cover_image = $coverimageurl;
            }

            // $banner->update([
            //     'name'       => $request->name,
            //     'slug'        => Str::slug($request->name),
            //     'type'        => $request->type,
            // ]);

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("Edit banner" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Banner $banner)
    {

        try {

            $banner->delete();

            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("Edit banner" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
