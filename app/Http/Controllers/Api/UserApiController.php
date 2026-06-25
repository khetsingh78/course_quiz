<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $user_id = auth()->user()->id;
            $user = User::with('purchage.items', 'subscription.subscription_plan', 'subscription.subscripton_exam')->findOrFail($user_id);

            return response()->json([
                'success' => true,
                'message' => 'User Details.',
                'data' => [
                    "user" => $user
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("user controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // dd($request->all());
        try {

            $user_id = auth()->user()->id;
            $user = User::findOrFail($user_id);
            $user->name = $request->name ?? $user->name;
            if ($request->filled('email') && $request->email !== $user->email) {
                if (User::where('email', $request->email)->exists()) {
                    return response()->json(["success" => false, "message" => "Email already exits.", "data" => (object)[]]);
                }
                $user->email = $request->email;
            }
            $user->gender = $request->gender ?? $user->gender;
            $user->save();
            return response()->json([
                'success' => true,
                'message' => 'Update Successfully.',
                'data' => [
                    "user" => $user
                ]
            ]);
        } catch (ValidationException $e) {
            return response()->json(["success" => false, "message" => $e->validator->errors()->first(), "data" => (object)[]]);
        } catch (\Throwable $th) {
            Log::info("user controller" . $th);
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
