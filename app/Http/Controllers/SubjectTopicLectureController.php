<?php

namespace App\Http\Controllers;

use App\Models\SubjectTopic;
use App\Models\SubjectTopicLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SubjectTopicLectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lectures = SubjectTopicLecture::where('subject_topic_id', $request->lecture)->get();
        $subject = SubjectTopic::with('subject')->where('id', $request->lecture)->first();
        // dd(json_decode($subject));

        $topicId = $request->lecture;
        return view('admin.lectures.index', compact('lectures', 'subject', 'topicId'));
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
                "topic_id" => 'required',
                "title" => 'required',
                // "lecture_type" => "required"
            ]);

            $videoPath = null;
            $pdfPath = null;
            if ($request->hasFile('pdf_file')) {
                $pdfPath = $request->file('pdf_file')->store('pdfs', 'public');
            }

            if ($request->has('video_url')) {
                $videoPath = $request->video_url;
            }

            if ($request->hasFile('video')) {
                $videoPath = $request->file('video')->store('videos', 'public');
            }

            SubjectTopicLecture::create([
                "subject_topic_id" => $request->topic_id,
                "title" => $request->title,
                "video_url" => $videoPath,
                "notes_pdf" => $pdfPath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Created successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info("Lecture added" . $th);
            return response()->json([
                'success' => true,
                'message' => 'Something went wrong.',
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubjectTopicLecture $subjectTopicLecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectTopicLecture $subjectTopicLecture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubjectTopicLecture $subjectTopicLecture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubjectTopicLecture $lecture)
    {
        // dd($lecture);
        try {

            $lecture->delete();

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
