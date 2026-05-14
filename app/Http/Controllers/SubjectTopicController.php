<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\SubjectTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubjectTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $topics = SubjectTopic::where('subject_id', $request->topics)->get();
        $subject = Subject::where('id', $request->topics)->first();
        return view('admin.topics.index', compact('topics', 'subject'));
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
                "name" => [
                    "required",
                    Rule::unique('subject_topics', 'name')
                        ->where(function ($query) use ($request) {
                            return $query->where('subject_id', $request->subject_id)
                                ->whereNull('deleted_at');
                        })
                ],
                "description" => "required"
            ]);

            SubjectTopic::create([
                "subject_id" => $request->subject_id,
                "name" => $request->name,
                "slug" => Str::slug($request->name),
                "description" => $request->description,
            ]);

            return redirect()->back()->with("success", "Created successfully.");
        } catch (\Throwable $th) {
            Log::info("Create Topics" . $th);
            return redirect()->back()->with("error", "Something went wrong.");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectTopic $subjectTopic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectTopic $subjectTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {

            $subjectTopic = SubjectTopic::where('id', $id);
            $subjectTopic->update([
                "name" => $request->name,
                "slug" => Str::slug($request->name),
                "description" => $request->description,
            ]);

            return redirect()->back()->with("success", "Updated successfully.");
        } catch (\Throwable $th) {
            Log::info("Create Topics" . $th);
            return redirect()->back()->with("error", "Something went wrong.");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {

        try {

            SubjectTopic::where('id', $id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("topic delete" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    // public function topics(Request $request, $id)
    // {
    //     // dd($request->all(), $id);
    //     $topics = SubjectTopic::where('subject_id', $id)->get();
    //     $subject = Subject::where('id', $id)->first();
    //     return view('admin.topics.index', compact('topics', 'subject'));
    // }
}
