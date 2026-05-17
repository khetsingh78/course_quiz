<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class SubscriptionPlanController extends Controller
{
    public function subscription_plan()
    {
        try {
            $plans = SubscriptionPlan::where('status', 1)->get();
            return response()->json([
                'success' => true,
                'message' => 'My Subscription Plan.',
                'data' => [
                    "plans" => $plans
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
