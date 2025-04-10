<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\ProductDescriptionContent;
use App\Models\ProductDescriptionTitle;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\search;

class StoreProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show', 'topSelling']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'nullable|exists:store_categories,id',
                'search' => 'nullable|string',
            ]);
            $categoryId = $request->category_id ?? null;
            if ($request->search !== null) {
                $products = StoreProduct::when($request->filled('search'), function ($query) use ($request) {
                    $searchTerm = '%' . $request->search . '%';
                    return $query->where(function ($q) use ($searchTerm) {
                        $q->where('title_ar', 'like', $searchTerm)
                            ->orWhere('title_en', 'like', $searchTerm)
                            ->orWhere('description_ar', 'like', $searchTerm)
                            ->orWhere('description_en', 'like', $searchTerm);
                    });
                })
                    ->paginate(12);
            } else {
                $products = StoreProduct::where('category_id', '=', $categoryId)
                    ->when($request->filled('search'), function ($query) use ($request) {
                        $searchTerm = '%' . $request->search . '%';
                        return $query->where(function ($q) use ($searchTerm) {
                            $q->where('title_ar', 'like', $searchTerm)
                                ->orWhere('title_en', 'like', $searchTerm)
                                ->orWhere('description_ar', 'like', $searchTerm)
                                ->orWhere('description_en', 'like', $searchTerm);
                        });
                    })
                    ->paginate(12);
            }
            return response()->json(
                $products,
                200,
            );
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
                'category_id' => 'required|exists:store_categories,id',
                'title_ar' => 'required|string',
                'title_en' => 'required|string',
                'description_ar' => 'required|string',
                'description_en' => 'required|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,excel,csv,txt,zip,rar,ppt,pptx,jpg,jpeg,png,gif,svg|max:50000',
                'price' => 'required|numeric',
                'discount' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                "terms_and_conditions_en" => "nullable|text",
                "terms_and_conditions_ar" => "nullable|text",
                'description_titles' => 'required|array',
                'description_titles.*.title_ar' => 'required|string',
                'description_titles.*.title_en' => 'required|string',
                'description_titles.*.contents' => 'required|array',
                'description_titles.*.contents.*.content_ar' => 'required|string',
                'description_titles.*.contents.*.content_en' => 'required|string',
            ]);

            $product = new StoreProduct();
            $product->category_id = $request->category_id;
            $product->title_ar = $request->title_ar;
            $product->title_en = $request->title_en;
            $product->description_ar = $request->description_ar;
            $product->description_en = $request->description_en;
            $product->terms_and_conditions_ar = $request->terms_and_conditions_ar;
            $product->terms_and_conditions_en = $request->terms_and_conditions_en;
            if ($request->hasFile('file')) {
                $fileName = 'files/store_products/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/store_products'), $fileName);
                $product->file = $fileName;
            }
            $product->price = $request->price;
            $product->discount = $request->discount;
            if ($request->hasFile('image')) {
                $imageName = 'images/store_products/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/store_products'), $imageName);
                $product->image = $imageName;
            }
            $product->save();

            foreach ($request->description_titles as $title) {
                $descriptionTitle = new ProductDescriptionTitle();
                $descriptionTitle->product_id = $product->id;
                $descriptionTitle->title_ar = $title['title_ar'];
                $descriptionTitle->title_en = $title['title_en'];
                $descriptionTitle->save();
                foreach ($title['contents'] as $content) {
                    $descriptionContent = new ProductDescriptionContent();
                    $descriptionContent->title_id = $descriptionTitle->id;
                    $descriptionContent->content_ar = $content['content_ar'];
                    $descriptionContent->content_en = $content['content_en'];
                    $descriptionContent->save();
                }
            }

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                ],
                201,
            );
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
    public function show(string $id): \Illuminate\Http\JsonResponse
    {
        try {
            $product = StoreProduct::findOrFail($id);

            $descriptions = ProductDescriptionTitle::where('product_id', '=', $product->id)
                ->get();

            foreach ($descriptions as $description) {
                $description->contents;
            }

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data fetched successfully.',
                    'data' => $product,
                    'descriptions' => $descriptions,
                ],
                200,
            );
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
                'category_id' => 'nullable|exists:store_categories,id',
                'title_ar' => 'nullable|string',
                'title_en' => 'nullable|string',
                'description_ar' => 'nullable|string',
                'description_en' => 'nullable|string',
                'file' => 'nullable|file|mimes:pdf,doc,docx,excel,csv,txt,zip,rar,ppt,pptx,jpg,jpeg,png,gif,svg|max:50000',
                'price' => 'nullable|numeric',
                'discount' => 'nullable|numeric',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
                "terms_and_conditions_en" => "nullable|text",
                "terms_and_conditions_ar" => "nullable|text",

            ]);

            $product = StoreProduct::findOrFail($id);
            $product->category_id = $request->category_id ?? $product->category_id;
            $product->title_ar = $request->title_ar ?? $product->title_ar;
            $product->title_en = $request->title_en ?? $product->title_en;
            $product->description_ar = $request->description_ar ?? $product->description_ar;
            $product->description_en = $request->description_en ?? $product->description_en;
            $product->terms_and_conditions_ar = $request->terms_and_conditions_ar ?? $product->terms_and_conditions_ar;
            $product->terms_and_conditions_en = $request->terms_and_conditions_en ?? $product->terms_and_conditions_en;
            if ($request->hasFile('file')) {
                if (file_exists(public_path($product->file))) {
                    unlink(public_path($product->file));
                }
                $fileName = 'files/store_products/' . time() . '.' . $request->file->extension();
                $request->file->move(public_path('files/store_products'), $fileName);
                $product->file = $fileName;
            }
            $product->price = $request->price ?? $product->price;
            $product->discount = $request->discount ?? $product->discount;
            if ($request->hasFile('image')) {
                if (file_exists(public_path($product->image))) {

                    unlink(public_path($product->image));
                }
                $imageName = 'images/store_products/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/store_products'), $imageName);
                $product->image = $imageName;
            }
            $product->save();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data created successfully.',
                ],
                201,
            );
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
            $product = StoreProduct::findOrFail($id);
            if (file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data deleted successfully.',
                ],
                200,
            );
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

    public function topSelling(Request $request)
    {
        try {
            $request->validate([
                'category_id' => 'nullable|exists:store_categories,id',
                'search' => 'nullable|string',
            ]);

            if ($request->search !== null) {
                $products = StoreProduct::when($request->filled('search'), function ($query) use ($request) {
                    $searchTerm = '%' . $request->search . '%';
                    return $query->where(function ($q) use ($searchTerm) {
                        $q->where('title_ar', 'like', $searchTerm)
                            ->orWhere('title_en', 'like', $searchTerm)
                            ->orWhere('description_ar', 'like', $searchTerm)
                            ->orWhere('description_en', 'like', $searchTerm);
                    });
                })
                    ->get();
            } else {
                $products = DB::table("top_selling_products_view")
                    ->when($request->filled('category_id'), function ($query) use ($request) {
                        return $query->where('category_id', '=', $request->category_id);
                    })
                    ->orderBy('total_sales', 'desc')
                    ->take(10)
                    ->get();
            }


            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $products,
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
}
