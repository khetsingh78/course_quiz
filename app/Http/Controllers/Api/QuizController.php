<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\quiz_attempts;
use App\Models\user_answers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class QuizController extends Controller
{
    public function saveQuizAttempt(Request $request)
    {
        // dd($request->all());
        try {

            $request->validate([
                'quiz_id' => 'required',
                'started_at' => 'required',
                "attempted_question" => 'required'
            ]);

            DB::beginTransaction();
            $user_id = auth()->user()->id;

            quiz_attempts::where('user_id', $user_id)->where('quiz_id', $request->quiz_id)->delete();

            $quiz_attempt = quiz_attempts::create([
                "user_id" => $user_id,
                "quiz_id" => $request->quiz_id,
                "started_at" => $request->started_at,
                "submitted_at" => now()
            ]);

            foreach ($request->attempted_question ?? [] as $key => $value) {
                // if ($value["selected_option_id"] != 0) {
                user_answers::create([
                    "quiz_attempt_id" => $quiz_attempt->id,
                    "question_id" => $value["question_id"],
                    "selected_option_id" => $value["selected_option_id"] == 0 ? null : $value["selected_option_id"],
                    "is_correct" => $value["selected_option_id"] == 0 ? 2 : $value["is_correct"],
                ]);
                // }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Saved Successfully',
                'data' => (object)[]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info($th);
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }

    public function quizAttemptedResult(Request $request)
    {
        // dd($request->all());
        try {

            $request->validate([
                'quiz_id' => 'required',
            ]);

            $user_id = auth()->user()->id;

            $count = user_answers::whereHas('quizAttempt', function ($query) use ($user_id, $request) {
                $query->where('user_id', $user_id)
                    ->where('quiz_id', $request->quiz_id);
            })
                ->selectRaw("
                    SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct,
                    SUM(CASE WHEN is_correct = 0 THEN 1 ELSE 0 END) as incorrect,
                    SUM(CASE WHEN is_correct = 2 THEN 1 ELSE 0 END) as unattempt
                ")
                ->first();


            $result = user_answers::with('questions', 'questions.options')
                ->whereHas('quizAttempt', function ($query) use ($user_id, $request) {
                    $query->where('user_id', $user_id)
                        ->where('quiz_id', $request->quiz_id);
                })
                ->get();

            return response()->json([
                'success' => true,
                "message" => "Quiz Result Successfull.",
                "data" => [
                    'count' => $count,
                    'quizresult' => $result
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
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
