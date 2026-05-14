<?php

namespace App\Http\Controllers;

use App\Imports\QuestionsImport;
use App\Models\options;
use App\Models\questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $quiz_id = $request->quiz_id;
        $questions = questions::with('options')->where('quiz_id', $request->quiz_id)->get();
        // dd(json_decode($questions));
        return view('admin.questions.index', compact("questions", 'quiz_id'));
        // dd($topics);
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
                "quiz_id" => 'required',
                "question" => 'required',
                // "option1" => 'required',
                // "option2" => 'required',
                // "option3" => 'required',
                // "option4" => 'required',
                "answear" => 'required',
            ]);

            $question = questions::create([
                "quiz_id" => $request->quiz_id,
                "question_text" => $request->question,
            ]);
            // dd($question, $request->options);
            foreach ($request->options as $key => $value) {
                options::create([
                    "question_id" => $question->id,
                    "option_text" => $key,
                    "option_value" => $value,
                    "is_correct" => $request->answear == $key ? 1 : 0,
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Created successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info($th);
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
    public function show(questions $questions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(questions $questions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, questions $question)
    {

        try {
            $request->validate([
                "question_id" => 'required',
                "question" => 'required',
                "answear" => 'required',
            ]);
            // dd($request->all());
            // dd($question);
            // $question_id = $question->id;
            $question->question_text = $request->question;
            $question->save();

            foreach ($request->options as $key => $value) {
                $option = Options::where('question_id', $question->id)
                    ->where('option_text', $key)
                    ->first();
                // dd($option);
                if ($option) {
                    $option->option_value = $value;
                    $option->is_correct = $option->option_text == $request->answear ? 1 : 0;
                    $option->save();
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Updated successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(questions $question)
    {
        // dd($id);
        try {
            $question->delete();
            return response()->json([
                'success' => true,
                'message' => 'Deleted successfully.'
            ]);
        } catch (\Throwable $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.'
            ]);
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'quiz_file' => 'required|mimes:xlsx'
        ]);

        Excel::import(
            new QuestionsImport($request->input('quiz_id')),
            $request->file('quiz_file')
        );
        return back()->with('success', 'imported successfully.');
    }
}
