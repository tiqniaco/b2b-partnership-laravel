<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\StoreCart;
use App\Models\StoreOrder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreOrderController extends Controller
{
    public $notification;

    public function __construct()
    {
        $this->notification = new NotificationController();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'status' => 'nullable|in:pending,approved,completed,canceled',
            ]);
            $userId = Auth::user()->id;

            if ($request->status) {
                $orders = StoreOrder::where('user_id', $userId)
                    ->where('status', $request->status)
                    ->get();
            } else {
                $orders = StoreOrder::where('user_id', $userId)->get();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $orders
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'phone' => 'nullable|string',
                'email' => 'nullable|email',
            ]);

            $userId = Auth::user()->id;

            $carts = StoreCart::where('user_id', $userId)->where('order_id', null)->get();
            if (count($carts) == 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Cart is empty.',
                ], 400);
            }
            $totalPrice = 0;

            $order = new StoreOrder();
            foreach ($carts as $cart) {
                $totalPrice += $cart->product->price - (($cart->product->discount * $cart->product->price) / 100);
            }
            $order->user_id = $userId;
            $order->total_price = $totalPrice;

            if ($request->phone) {
                $order->phone = $request->phone;
            }
            if ($request->email) {
                $order->email = $request->email;
            }
            $order->save();

            foreach ($carts as $cart) {
                $cart->order_id = $order->id;
                $cart->save();
            }

            $this->notification->sendNotification(
                topic: "admins",
                title: "New Order",
                body: "New order created",
                data: [
                    'order_id' => (string)$order->id,
                    'user_id' => (string)$order->user_id
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Order created successfully.',
            ], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $order = StoreOrder::findOrFail($id);
            $carts = StoreCart::where('order_id', $order->id)->get();
            $client = DB::table('client_details_view')
                ->where('user_id', $order->user_id)
                ->first();

            $items = [];

            foreach ($carts as $cart) {
                $items[] = $cart->product;
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'client' => $client,
                'data' => $order,
                'items' => $items,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => 'nullable|in:pending,approved,completed,canceled',
            ]);

            $order = StoreOrder::findOrFail($id);
            if ($order->status == 'approved') {
                $order->expiration_date = now()->addMonth(1);
            }

            $oldStatus = $order->status;
            $order->status = $request->status ?? $order->status;
            $order->save();

            // إنشاء روابط التحميل عند الموافقة على الطلب أو اكتماله
            if (in_array($order->status, ['approved', 'completed']) && $oldStatus !== $order->status) {
                $user = $order->user;
                $products = $order->products; // جلب جميع المنتجات في الطلب
                $downloadTokens = [];

                foreach ($products as $product) {
                    // إنشاء رابط تحميل لكل منتج
                    $token = app(\App\Services\DownloadService::class)
                        ->createDownloadToken($user, $product, 3, 1, $order->id);

                    $downloadTokens[] = $token;
                }

                if (!empty($downloadTokens)) {
                    // إرسال البريد الإلكتروني مع روابط التحميل
                    app(\App\Services\EmailService::class)
                        ->sendDownloadLinksEmail($user, $order, $downloadTokens);

                    // إرسال إشعار FCM (اختياري)
                    app(\App\Services\FCMService::class)
                        ->sendToUser($user, '✅ طلبك جاهز للتحميل', 'اضغط لتحميل الحقيبة التدريبية.');
                }
            }


            $this->notification->sendNotification(
                topic: "user" . $order->user_id,
                title: "Order Status",
                body: "Order " . $order->id . " status updated, new status is " . $order->status,
                data: [
                    'order_id' => (string)$order->id,
                    'user_id' => (string)$order->user_id
                ]
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Data updated successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $order = StoreOrder::findOrFail($id);
            $order->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function adminOrders(Request $request)
    {
        try {
            $request->validate([
                'status' => 'nullable|in:pending,approved,completed,canceled',
            ]);
            $user = User::findOrFail(Auth::user()->id);
            if ($user->role != "admin") {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You don\'t have permission.',
                ], 403);
            }

            if ($request->status) {
                $orders = StoreOrder::where('status', $request->status)
                    ->orderBy('created_at', 'desc')
                    ->paginate(20);
            } else {
                $orders = StoreOrder::orderBy('created_at', 'desc')
                    ->paginate(20);
            }

            return response()->json($orders, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not found.',
                'error' => $e->getMessage(),
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error.',
                'error' => $e->getMessage(),
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
