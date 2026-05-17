<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Course;
use App\Models\Order;
use App\Models\SubjectTopicLecture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CourseApiController extends Controller
{

    public function home(Request $request)
    {
        // dd($request->all());
        try {

            $exam = Category::where('type', 'main')->take(10)->get();
            $banner = Banner::take(10)->get();
            $popular_course = Course::where('type', 'Course')
                ->where("price", ">", 0)
                ->where("popular", true)
                ->with('subjects', 'subjects.topics')
                ->when($request->filled('category_id'), function ($query) use ($request) {
                    $query->where('category_id', $request->category_id);
                })
                ->latest()->take(10)->get();
            $popular_series = Course::with('category:id,name', 'quizzes')
                ->where("price", ">", 0)
                ->where("popular", true)
                ->where('type', 'Test-Series')
                ->when(
                    $request->filled('category_id'),
                    fn($q) => $q->where('category_id', $request->category_id)
                )
                ->get();

            $notes = SubjectTopicLecture::whereNotNull('notes_pdf')->latest()->take(10)->get(['id', 'notes_pdf']);
            return response()->json([
                'success' => true,
                'message' => 'Home list.',
                'data' => [
                    "banner" => $banner,
                    "exam" => $exam,
                    "popular_courses" => $popular_course,
                    "popular_series" => $popular_series,
                    "notes" => $notes
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("Course api controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }
    public function exams(Request $request)
    {
        // dd($request->all());
        try {
            $exam = Category::where('type', 'main')->get();
            return response()->json([
                'success' => true,
                'message' => 'Exams list.',
                'data' => [
                    "exam" => $exam,
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("Course api controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }
    public function courses(Request $request)
    {
        // dd($request->all());
        try {

            $exams = Category::where('type', 'main')->get();
            $course = Course::with('category:id,name', 'subjects', 'subjects.topics')
                ->where("price", ">", 0)
                ->where('type', 'Course')
                ->when(
                    $request->filled('category_id'),
                    fn($q) => $q->where('category_id', $request->category_id)
                )
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'All Courses successfully.',
                'data' => [
                    "exams" => $exams,
                    "courses" => $course
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("Course api controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }
    public function testSeries(Request $request)
    {
        // dd($request->all());
        try {

            $exams = Category::where('type', 'main')->get();
            //fetch based on islocked
            $course = Course::with(['category:id,name', 'quizzes' => function ($query) {
                $query->withCount('questions');
            }])
                ->where("price", ">", 1)
                ->where('type', 'Test-Series')
                ->when(
                    $request->filled('category_id'),
                    fn($q) => $q->where('category_id', $request->category_id)
                )
                ->get();
            $course->each(function ($courseItem) {
                $courseItem->quizzes->each(function ($quiz) {
                    $quiz->when(
                        $quiz->islocked == 0,
                        function ($q) use ($quiz) {
                            $quiz->load('questions.options');
                        }
                    );
                });
            });
            return response()->json([
                'success' => true,
                'message' => 'All Test series successfully.',
                'data' => [
                    "exams" => $exams,
                    "testseries" => $course
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("Course api controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }

    public function exam_wise_course(Request $request)
    {
        // dd($request->all());
        try {

            $request->validate([
                'category_id' => 'required'
            ]);

            $course = Course::with('category:id,name', 'subjects', 'subjects.topics')
                ->where("price", ">", 1)
                ->where('category_id', $request->category_id)
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'Exam wise courses list.',
                'data' => [
                    "courses" => $course
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("Course api controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }

    public function lectures(Request $request)
    {
        // dd($request->all());
        try {

            $request->validate([
                'topic_id' => 'required'
            ]);

            $topics = SubjectTopicLecture::where('subject_topic_id', $request->topic_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Lectures List.',
                'data' => [
                    "lectures" => $topics
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("Course api controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }

    public function myCourses(Request $request)
    {
        // dd($request->all());
        try {
            $user_id = auth()->user()->id;
            $courses = Course::where('type', 'Course')
                ->with('category:id,name', 'subjects', 'subjects.topics')
                ->whereHas('orderItems.order', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->where('payment_status', 'paid');
                })
                ->get();

            // $exams = Category::where('type', 'main')->get();
            return response()->json([
                'success' => true,
                'message' => 'My Courses.',
                'data' => [
                    // "exams" => $exams,
                    "courses" => $courses
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


    public function myTestSeries(Request $request)
    {
        // dd($request->all());
        try {
            $user_id = auth()->user()->id;
            $testseries = Course::where('type', 'Test-Series')
                ->with([
                    'category:id,name',
                    'quizzes.questions',
                    'quizzes.questions.options',
                    'quizzes' => function ($query) use ($user_id) {
                        $query->withExists([
                            'isTestAttempt as attempted' => function ($q) use ($user_id) {
                                $q->where('user_id', $user_id);
                            }
                        ]);
                        $query->withCount('questions');
                    },

                ])
                ->whereHas('orderItems.order', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id)
                        ->where('payment_status', 'paid');
                })
                ->get();
            return response()->json([
                'success' => true,
                'message' => 'My Test Series.',
                'data' => [
                    "testseries" => $testseries
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

    public function freeCourse(Request $request)
    {
        // dd($request->all());
        try {
            $free_course = Course::with('category:id,name', 'subjects', 'subjects.topics')
                ->where("price", "<", 1)
                ->where('type', 'Course')
                ->when(
                    $request->filled('category_id'),
                    fn($q) => $q->where('category_id', $request->category_id)
                )
                ->latest()->take(10)->get();

            // $exams = Category::where('type', 'main')->get();
            return response()->json([
                'success' => true,
                'message' => 'My Courses.',
                'data' => [
                    "courses" => $free_course
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

    public function freeTestSeries(Request $request)
    {
        // dd($request->all());
        try {
            $user_id = auth()->user()->id;
            $testseries = Course::where('type', 'Test-Series')
                ->with([
                    'category:id,name',
                    'quizzes.questions',
                    'quizzes.questions.options',
                    'quizzes' => function ($query) use ($user_id) {
                        $query->withExists([
                            'isTestAttempt as attempted' => function ($q) use ($user_id) {
                                $q->where('user_id', $user_id);
                            }
                        ]);
                        $query->withCount('questions');
                    }
                ])
                ->where("price", "<", 1)
                ->where('type', 'Test-Series')
                ->when(
                    $request->filled('category_id'),
                    fn($q) => $q->where('category_id', $request->category_id)
                )
                ->latest()->take(10)->get();

            // $exams = Category::where('type', 'main')->get();
            return response()->json([
                'success' => true,
                'message' => 'Free test series.',
                'data' => [
                    "testseries" => $testseries
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
