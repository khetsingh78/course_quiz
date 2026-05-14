<?php

namespace App\Http\Controllers;

use App\Models\Quizze;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuizzesController extends Controller
{
    public function index(Request $request)
    {
        // $topics = questions::where('subject_id', $request->quiz)->get();
        // return view('admin.quize.index', compact('topics', 'subject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::get();
        // return view('admin.quizzes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {

            $request->validate([
                "test_id" => 'required',
                "title" => 'required',
                "total_marks" => 'required',
                "duration" => 'required',
                "islocked" => 'required',
                "description" => 'required',
            ]);


            $test = Quizze::create([
                'course_id' => $request->test_id,
                'name' => $request->title,
                'total_marks' => $request->total_marks,
                'duration' => $request->duration,
                'islocked' => $request->islocked,
                'description' =>  $request->description ?? null,

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
    public function show(Quizze $Quizze) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quizze $Quizze) //Quizze $Quizze
    {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quizze $Quizze) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quizze $Quizze, $id)
    {
        // dd($Quizze->first());
        try {

            $Quizze->destroy($id);
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
