<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $request->validate([
                'specialization_id' => 'nullable|exists:specializations,id',
                'sub_specialization_id' => 'nullable|exists:sub_specializations,id',
                'country_id' => 'nullable|exists:countries,id',
                'government_id' => 'nullable|exists:governments,id',
                'contract_type' => 'nullable|string',
                'expiry_date' => 'nullable|date',
            ]);

            $jobs = DB::table('job_details_view')
                ->where('status', "searching")
                ->when(request()->filled('specialization_id'), function ($query) {
                    return $query->where('specialization_id', request()->specialization_id);
                })
                ->when(request()->filled('sub_specialization_id'), function ($query) {
                    return $query->where('sub_specialization_id', request()->sub_specialization_id);
                })
                ->when(request()->filled('country_id'), function ($query) {
                    return $query->where('country_id', request()->country_id);
                })
                ->when(request()->filled('government_id'), function ($query) {
                    return $query->where('government_id', request()->government_id);
                })
                ->when(request()->filled('contract_type'), function ($query) {
                    return $query->where('contract_type', request()->contract_type);
                })
                ->when(request()->filled('expiry_date'), function ($query) {
                    return $query->whereDate('expiry_date', '>=', request()->expiry_date);
                })
                ->orderBy('job_created_at', 'desc')
                ->paginate(12);

            return response()->json($jobs, 200);
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
                'title' => 'required|string',
                'description' => 'required|string',
                'skills' => 'required|string',
                'experience' => 'required|string',
                'contract_type' => 'required|string',
                'expiry_date' => 'required|date',
                'gender' => 'required|in:male,female,any',
                'salary' => 'nullable|integer',
                'employer_id' => 'required|integer|exists:providers,id',
                'government_id' => 'required|integer|exists:governments,id',
                'sub_specialization_id' => 'required|integer|exists:sub_specializations,id',
            ]);

            $job = new Job();
            $job->title = $request->title;
            $job->description = $request->description;
            $job->skills = $request->skills;
            $job->experience = $request->experience;
            $job->contract_type = $request->contract_type;
            $job->expiry_date = $request->expiry_date;
            $job->gender = $request->gender;
            $job->salary = $request->salary;
            $job->employer_id = $request->employer_id;
            $job->government_id = $request->government_id;
            $job->sub_specializations_id = $request->sub_specialization_id;
            $job->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Job created successfully.',
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $jobs = DB::table('job_details_view')
                ->where('id', $id)
                ->first();

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully.',
                'data' => $jobs
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
                'title' => 'nullable|string',
                'description' => 'nullable|string',
                'skills' => 'nullable|string',
                'experience' => 'nullable|string',
                'contract_type' => 'nullable|string',
                'expiry_date' => 'nullable|date',
                'gender' => 'nullable|in:male,female,any',
                'salary' => 'nullable|integer',
                'status' => 'nullable|in:hired,searching',
                'employer_id' => 'nullable|integer|exists:providers,id',
                'governments_id' => 'nullable|integer|exists:governments,id',
                'sub_specialization_id' => 'nullable|integer|exists:sub_specializations,id',
            ]);

            $job = Job::findOrFail($id);
            $job->title = $request->title ?? $job->title;
            $job->description = $request->description ?? $job->description;
            $job->skills = $request->skills ?? $job->skills;
            $job->experience = $request->experience ?? $job->experience;
            $job->contract_type = $request->contract_type ?? $job->contract_type;
            $job->expiry_date = $request->expiry_date ?? $job->expiry_date;
            $job->gender = $request->gender ?? $job->gender;
            $job->status = $request->status ?? $job->status;
            $job->salary = $request->salary;
            $job->employer_id = $request->employer_id ?? $job->employer_id;
            $job->governments_id = $request->governments_id ?? $job->governments_id;
            $job->sub_specializations_id = $request->sub_specialization_id ?? $job->sub_specializations_id;
            $job->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Job updated successfully.',
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
            $job = Job::findOrFail($id);
            $job->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data deleted successfully.',
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
