<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class QuizTestSeriesController extends Controller
{
    public function index()
    {
        $courses = Course::where('type', 'Test-Series')->with('category')->latest()->get();
        return view('admin.testseries.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.testseries.create', compact('categories'));
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
                "description" => 'required',
                "cover_image" => 'required|mimes:jpeg,png,jpg,svg',
                "category" => 'required',
                "price" => 'required',
                "discount_type" => 'required',
                "discount_value" => 'required',
            ]);

            $coverimageurl = $request->file("cover_image")->store("course", 'public');
            $coverimageurl = $coverimageurl;

            $course = Course::create([
                'category_id' => $request->category,
                'title' => $request->title,
                'type' => "Test-Series",
                'slug' => Str::slug($request->title, '-'),
                'description' =>  $request->description ?? null,
                'thumbnail' =>  $coverimageurl,
                'price' =>  $request->price,
                'dis_type' =>  $request->discount_type,
                'dis_price' =>  $request->discount_value,
            ]);


            return redirect()->back()->with("success", "Created successfully.");
        } catch (\Throwable $th) {
            Log::info("Exception" . $th);
            return redirect()->back()->with("error", "Something went wrong.")->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, $id)
    {
        $course =  $course->with('category', 'quizzes')->find($id);
        // dd(json_decode($course));
        return view('admin.testseries.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, $id) //Course $course
    {
        // dd($course->first());
        $course =  $course->find($id);
        // $sub_names = $course->subjects->pluck('name');
        // dd(json_decode($subjectNames));
        $categories = Category::get();
        return view('admin.testseries.edit', compact('course', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // dd($course->first());
        try {
            DB::beginTransaction();
            $request->validate([
                "title" => 'required',
                "description" => 'required',
                // "cover_image" => 'required|mimes:jpeg,png,jpg,svg',
                "category" => 'required',
                "price" => 'required',
                "discount_type" => 'required',
                "discount_value" => 'required',
            ]);

            $course =  $course->first();
            // $Exiting_subject = $course->subjects->pluck('name');
            // $subjects = collect($request->subjects);


            if ($request->hasFile('cover_image')) {
                // $previous_img = explode($request->getSchemeAndHttpHost(), $course->thumbnail)[1];
                $previous_img =  $course->thumbnail;
                if ($course->thumbnail && Storage::disk('public')->exists($previous_img)) {
                    Storage::disk('public')->delete($previous_img);
                }
                $coverimageurl = $request->file('cover_image')->store('course', 'public');
                $coverimageurl = $coverimageurl;
                $course->thumbnail = $coverimageurl;
            }

            $course->update([
                'category_id' => $request->category,
                'title'       => $request->title,
                'slug'        => Str::slug($request->title),
                'description' => $request->description,
                'price'       => $request->price,
                'dis_type'    => $request->discount_type,
                'dis_price'   => $request->discount_value,
            ]);


            DB::commit();
            return redirect()->back()->with("success", "Updated successfully.");
        } catch (\Throwable $th) {
            Log::info("Edit Course" . $th);
            DB::rollBack();
            return redirect()->back()->with("error", "Something went wrong.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {

            // dd($course->first());
            $course->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("Delete Course" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }
}
