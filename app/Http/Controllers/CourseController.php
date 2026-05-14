<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('type', 'Course')->with('category')->latest()->get();
        return view('admin.course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('admin.course.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
                'type' => "Course",
                'slug' => Str::slug($request->title, '-'),
                'description' =>  $request->description ?? null,
                'thumbnail' =>  $coverimageurl,
                'price' =>  $request->price,
                'dis_type' =>  $request->discount_type,
                'dis_price' =>  $request->discount_value,
            ]);

            foreach ($request->subjects ?? [] as $key => $value) {
                Subject::create([
                    "course_id" => $course->id,
                    "name" => $value,
                    "slug" => $value,
                ]);
            }

            return redirect()->back()->with("success", "Created successfully.");
        } catch (\Throwable $th) {
            Log::info("add category" . $th);
            return redirect()->back()->with("error", "Something went wrong.")->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $course =  $course->load('subjects', 'category');
        // dd(json_decode($course));
        return view('admin.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course) //Course $course
    {
        $course =  $course->load('subjects');
        $sub_names = $course->subjects->pluck('name');
        // dd(json_decode($subjectNames));
        $categories = Category::get();
        return view('admin.course.edit', compact('course', 'categories', 'sub_names'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        // dd($course->id);
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

            $course =  $course->load('subjects');
            $Exiting_subject = $course->subjects->pluck('name');
            $subjects = collect($request->subjects);


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

            //update mapped subjects.
            foreach ($subjects ?? [] as $value) {
                if (!$Exiting_subject->contains($value)) {
                    Subject::create([
                        "course_id" => $course->id,
                        "name" => $value,
                        "slug" => Str::slug($value),
                    ]);
                }
            }
            foreach ($Exiting_subject ?? [] as $value) {
                if (!$subjects->contains($value)) {
                    Subject::where('course_id', $course->id)->where('name', $value)->delete();
                }
            }
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

    public function isPopular(Request $request)
    {
        // dd($request->all());
        try {
            $request->validate([
                'course_id' => 'required',
                'toggle' => 'required'
            ]);

            $course = Course::findOrFail($request->course_id);
            $course->update([
                'popular' => $request->toggle
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Updated Successfully.',
                'data' => (object)[]
            ]);
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }
}
