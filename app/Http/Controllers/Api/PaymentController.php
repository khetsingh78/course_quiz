<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function createOrder(Request $request)
    {

        try {

            $request->validate([
                "course_id" => "required",
                // "course_id"=>"required",
            ]);


            $course = Course::findOrFail($request->course_id);
            // dd($course);

            DB::beginTransaction();
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $user_id = auth()->user()->id;
            // dd($user_id);
            $total_amount = $course->price;
            $dis_amount = 0;
            $final_amount = $course->price;
            if ($course->dis_type == 'flat') {
                $total_amount = $course->price;
                $dis_amount = $course->dis_price;
                $final_amount = $course->price - $course->dis_price;
            } elseif ($course->precent == 'precent') {
                $total_amount = $course->price;
                $dis_amount = ($course->price * $course->dis_price) / 100;
                $final_amount = $course->price - $dis_amount;
            }

            $course_order = Order::create([
                "user_id" => $user_id,
                "order_number" => '0000',
                "total_amount" => $total_amount,
                "dis_amount" => $dis_amount,
                'gst_amount' => 0,
                'final_amount' => $final_amount,
                // 'coupon' => $summary['coupon'],
                // 'deliver_charge' => '10',
                // 'gatway_charge' => '1',
            ]);

            OrderItem::create([
                "order_id" => $course_order->id,
                "course_id" => $course->id,
                "price" => $course_order->total_amount,
                "dis_price" => $course_order->dis_amount,
                "gst_price" => $course_order->gst_amount,
                "final_price" => $course_order->final_amount,
            ]);

            $order = $api->order->create([
                'receipt' => 'order_' . $course_order->id,
                'amount' =>  $course_order->final_amount * 100, // amount in paise
                'currency' => 'INR',
                'payment_capture' => 1,
            ]);

            $course_order->update([
                'razorpay_order_id' => $order['id']
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                "message" => "Order id generated.",
                "data" => [
                    'order_id' => $order['id'],
                    'amount' => $order['amount'],
                    'key' => env('RAZORPAY_KEY')
                ]
            ]);
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

    public function verifyPayment(Request $request)
    {

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            // Update order status
            $order->update([
                "transaction_id" => $request->razorpay_payment_id,
                'payment_status' => 'paid',
                'signature'  => $request->razorpay_signature,
            ]);

            return response()->json([
                'success' => true,
                "message" => "Payment successfull.",
                "data" => (object)[]
            ]);
        } catch (\Exception $th) {
            Log::info($th);
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
                'data' => (object)[],
                'error' => $th->getMessage()
            ]);
        }
    }


    public function paymentFailed(Request $request)
    {

        try {
            //code...
            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();

            $order->update([
                "transaction_id" => $request->razorpay_payment_id,
                'payment_status' => 'failed',
            ]);

            return response()->json([
                'success' => true,
                "message" => "Payment Failed.",
                "data" => (object)[]
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
