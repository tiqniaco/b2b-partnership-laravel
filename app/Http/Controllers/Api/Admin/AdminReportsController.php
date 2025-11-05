<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StoreOrder;
use App\Models\StoreProduct;
use App\Models\DownloadToken;
use App\Models\RequestService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        // Add admin permission check if using Spatie permissions
        // $this->middleware('permission:view-admin-reports');
    }

    /**
     * Get general statistics dashboard
     * GET /api/admin/reports/dashboard
     */
    public function dashboard(Request $request): JsonResponse
    {
        try {
            $dateRange = $this->getDateRange($request);

            // Users statistics
            $usersStats = [
                'total_users' => User::count(),
                'new_users_today' => User::whereDate('created_at', today())->count(),
                'new_users_this_month' => User::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'active_users_with_fcm' => User::whereNotNull('fcm_token')->count(),
            ];

            // Orders statistics
            $ordersStats = [
                'total_orders' => StoreOrder::count(),
                'orders_today' => StoreOrder::whereDate('created_at', today())->count(),
                'orders_this_month' => StoreOrder::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count(),
                'total_revenue' => StoreOrder::sum('total'),
                'revenue_this_month' => StoreOrder::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('total'),
            ];

            // Products statistics
            $productsStats = [
                'total_products' => StoreProduct::count(),
                'products_with_demo' => StoreProduct::whereNotNull('demo_file')->count(),
                'most_downloaded_product' => $this->getMostDownloadedProduct(),
            ];

            // Downloads statistics
            $downloadsStats = [
                'total_download_tokens' => DownloadToken::count(),
                'active_tokens' => DownloadToken::where('expires_at', '>', now())
                    ->where('downloads_count', '<', DB::raw('max_downloads'))
                    ->count(),
                'total_downloads' => DownloadToken::sum('downloads_count'),
                'downloads_today' => DownloadToken::whereDate('last_downloaded_at', today())->sum('downloads_count'),
            ];

            // Services statistics
            $servicesStats = [
                'total_service_requests' => RequestService::count(),
                'pending_services' => RequestService::where('status', 'pending')->count(),
                'completed_services' => RequestService::where('status', 'completed')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'users' => $usersStats,
                    'orders' => $ordersStats,
                    'products' => $productsStats,
                    'downloads' => $downloadsStats,
                    'services' => $servicesStats,
                    'generated_at' => now(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate dashboard report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get downloads report
     * GET /api/admin/reports/downloads
     */
    public function downloadsReport(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
                'product_id' => 'nullable|integer|exists:store_products,id',
                'user_id' => 'nullable|integer|exists:users,id',
                'status' => 'nullable|in:active,expired,exhausted',
                'per_page' => 'nullable|integer|min:10|max:100'
            ]);

            $query = DownloadToken::with(['user:id,name,email', 'product:id,name', 'order:id,total']);

            // Apply filters
            if ($request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->product_id) {
                $query->where('product_id', $request->product_id);
            }

            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            if ($request->status) {
                switch ($request->status) {
                    case 'active':
                        $query->where('expires_at', '>', now())
                            ->where('downloads_count', '<', DB::raw('max_downloads'));
                        break;
                    case 'expired':
                        $query->where('expires_at', '<=', now());
                        break;
                    case 'exhausted':
                        $query->where('downloads_count', '>=', DB::raw('max_downloads'));
                        break;
                }
            }

            $tokens = $query->orderBy('created_at', 'desc')
                ->paginate($request->per_page ?? 20);

            // Add computed fields
            foreach ($tokens as $token) {
                $token->is_active = $token->expires_at > now() && $token->downloads_count < $token->max_downloads;
                $token->remaining_downloads = $token->max_downloads - $token->downloads_count;
            }

            return response()->json([
                'success' => true,
                'data' => $tokens->items(),
                'pagination' => [
                    'current_page' => $tokens->currentPage(),
                    'last_page' => $tokens->lastPage(),
                    'per_page' => $tokens->perPage(),
                    'total' => $tokens->total()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate downloads report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get orders report
     * GET /api/admin/reports/orders
     */
    public function ordersReport(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
                'status' => 'nullable|string',
                'min_amount' => 'nullable|numeric|min:0',
                'max_amount' => 'nullable|numeric|min:0',
                'user_id' => 'nullable|integer|exists:users,id',
                'per_page' => 'nullable|integer|min:10|max:100'
            ]);

            $query = StoreOrder::with(['user:id,name,email']);

            // Apply filters
            if ($request->date_from) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->min_amount) {
                $query->where('total', '>=', $request->min_amount);
            }

            if ($request->max_amount) {
                $query->where('total', '<=', $request->max_amount);
            }

            if ($request->user_id) {
                $query->where('user_id', $request->user_id);
            }

            $orders = $query->orderBy('created_at', 'desc')
                ->paginate($request->per_page ?? 20);

            // Add summary statistics
            $summary = [
                'total_orders' => $query->count(),
                'total_amount' => $query->sum('total'),
                'average_order_value' => $query->avg('total'),
            ];

            return response()->json([
                'success' => true,
                'data' => $orders->items(),
                'summary' => $summary,
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'last_page' => $orders->lastPage(),
                    'per_page' => $orders->perPage(),
                    'total' => $orders->total()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate orders report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products performance report
     * GET /api/admin/reports/products-performance
     */
    public function productsPerformanceReport(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
                'sort_by' => 'nullable|in:downloads,orders,revenue',
                'per_page' => 'nullable|integer|min:10|max:100'
            ]);

            $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : Carbon::now()->subMonth();
            $dateTo = $request->date_to ? Carbon::parse($request->date_to) : Carbon::now();

            // Get products with performance metrics
            $products = StoreProduct::select([
                'store_products.id',
                'store_products.name',
                'store_products.price',
                'store_products.demo_file',
                DB::raw('COUNT(DISTINCT download_tokens.id) as total_downloads'),
                DB::raw('COUNT(DISTINCT store_orders.id) as total_orders'),
                DB::raw('SUM(store_orders.total) as total_revenue'),
                DB::raw('SUM(download_tokens.downloads_count) as actual_downloads')
            ])
                ->leftJoin('download_tokens', function ($join) use ($dateFrom, $dateTo) {
                    $join->on('store_products.id', '=', 'download_tokens.product_id')
                        ->whereBetween('download_tokens.created_at', [$dateFrom, $dateTo]);
                })
                ->leftJoin('store_orders', function ($join) use ($dateFrom, $dateTo) {
                    $join->on('store_products.id', '=', 'store_orders.product_id')
                        ->whereBetween('store_orders.created_at', [$dateFrom, $dateTo]);
                })
                ->groupBy('store_products.id', 'store_products.name', 'store_products.price', 'store_products.demo_file');

            // Apply sorting
            switch ($request->sort_by) {
                case 'downloads':
                    $products->orderBy('actual_downloads', 'desc');
                    break;
                case 'orders':
                    $products->orderBy('total_orders', 'desc');
                    break;
                case 'revenue':
                    $products->orderBy('total_revenue', 'desc');
                    break;
                default:
                    $products->orderBy('total_revenue', 'desc');
            }

            $result = $products->paginate($request->per_page ?? 20);

            // Add computed fields
            foreach ($result as $product) {
                $product->has_demo = !is_null($product->demo_file);
                $product->average_order_value = $product->total_orders > 0
                    ? $product->total_revenue / $product->total_orders
                    : 0;
            }

            return response()->json([
                'success' => true,
                'data' => $result->items(),
                'pagination' => [
                    'current_page' => $result->currentPage(),
                    'last_page' => $result->lastPage(),
                    'per_page' => $result->perPage(),
                    'total' => $result->total()
                ],
                'date_range' => [
                    'from' => $dateFrom->toDateString(),
                    'to' => $dateTo->toDateString()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate products performance report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get users activity report
     * GET /api/admin/reports/users-activity
     */
    public function usersActivityReport(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date|after_or_equal:date_from',
                'has_fcm_token' => 'nullable|boolean',
                'per_page' => 'nullable|integer|min:10|max:100'
            ]);

            $dateFrom = $request->date_from ? Carbon::parse($request->date_from) : Carbon::now()->subMonth();
            $dateTo = $request->date_to ? Carbon::parse($request->date_to) : Carbon::now();

            $query = User::select([
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.fcm_token',
                DB::raw('COUNT(DISTINCT store_orders.id) as total_orders'),
                DB::raw('SUM(store_orders.total) as total_spent'),
                DB::raw('COUNT(DISTINCT download_tokens.id) as download_tokens_count'),
                DB::raw('SUM(download_tokens.downloads_count) as total_downloads')
            ])
                ->leftJoin('store_orders', function ($join) use ($dateFrom, $dateTo) {
                    $join->on('users.id', '=', 'store_orders.user_id')
                        ->whereBetween('store_orders.created_at', [$dateFrom, $dateTo]);
                })
                ->leftJoin('download_tokens', function ($join) use ($dateFrom, $dateTo) {
                    $join->on('users.id', '=', 'download_tokens.user_id')
                        ->whereBetween('download_tokens.created_at', [$dateFrom, $dateTo]);
                })
                ->groupBy('users.id', 'users.name', 'users.email', 'users.created_at', 'users.fcm_token');

            // Apply filters
            if ($request->has('has_fcm_token')) {
                if ($request->has_fcm_token) {
                    $query->whereNotNull('users.fcm_token');
                } else {
                    $query->whereNull('users.fcm_token');
                }
            }

            $users = $query->orderBy('total_spent', 'desc')
                ->paginate($request->per_page ?? 20);

            // Add computed fields
            foreach ($users as $user) {
                $user->has_fcm_token = !is_null($user->fcm_token);
                $user->average_order_value = $user->total_orders > 0
                    ? $user->total_spent / $user->total_orders
                    : 0;
                // Hide actual FCM token for security
                unset($user->fcm_token);
            }

            return response()->json([
                'success' => true,
                'data' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total()
                ],
                'date_range' => [
                    'from' => $dateFrom->toDateString(),
                    'to' => $dateTo->toDateString()
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate users activity report',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function getDateRange(Request $request): array
    {
        $dateFrom = $request->date_from
            ? Carbon::parse($request->date_from)
            : Carbon::now()->subMonth();

        $dateTo = $request->date_to
            ? Carbon::parse($request->date_to)
            : Carbon::now();

        return [$dateFrom, $dateTo];
    }

    private function getMostDownloadedProduct(): ?array
    {
        $product = StoreProduct::select([
            'store_products.id',
            'store_products.name',
            DB::raw('SUM(download_tokens.downloads_count) as total_downloads')
        ])
            ->leftJoin('download_tokens', 'store_products.id', '=', 'download_tokens.product_id')
            ->groupBy('store_products.id', 'store_products.name')
            ->orderBy('total_downloads', 'desc')
            ->first();

        return $product ? [
            'id' => $product->id,
            'name' => $product->name,
            'total_downloads' => $product->total_downloads ?? 0
        ] : null;
    }
}
