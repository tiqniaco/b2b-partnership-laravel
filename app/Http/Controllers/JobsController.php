<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $jobs = Job::select(
                'jobs.id',
                'jobs.job_title',
                'jobs.job_description',
                'jobs.image',
                'jobs.is_urgent',
                'jobs.start_price',
                'jobs.end_price',
                'jobs.salary_type',
                'jobs.contract_type',
                'jobs.years_of_experience',
                'jobs.gender',
                'jobs.qualifications',
                'jobs.key_responsibilities',
                'jobs.skill_and_experience',
                'jobs.job_skills',
                'jobs.job_location',
                'jobs.expiration_date',
                'providers.id as provider_id',
                'users.name as provider_name',
                'users.email as provider_email',
                'users.phone as provider_phone',
                'users.country_code as provider_country_code',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'countries.flag as country_flag',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_en as specialization_name',
                'sub_specializations.name_ar as specialization_name_ar',
                'jobs.created_at',
                'jobs.updated_at'
            )
                ->join('providers', 'providers.id', '=', 'jobs.provider_id')
                ->join('users', 'providers.user_id', '=', 'users.id')
                ->join('governments', 'governments.id', '=', 'jobs.governments_id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->join('sub_specializations', 'sub_specializations.id', '=', 'jobs.sub_specialization_id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->orderBy('jobs.is_urgent', 'desc')
                ->paginate(12);

            return response()->json(
                $jobs,
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
                'job_title' => 'required|string|max:255',
                'job_description' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'is_urgent' => 'required|boolean',
                'start_price' => 'required|numeric',
                'end_price' => 'required|numeric',
                'salary_type' => 'required|in:monthly,weekly',
                'contract_type' => 'required|in:full_time,part_time,hourly',
                'years_of_experience' => 'required',
                'gender' => 'required|in:male,female,both',
                'qualifications' => 'required|string',
                'key_responsibilities' => 'required|string',
                'skill_and_experience' => 'required|string',
                'job_skills' => 'required|string',
                'job_location' => 'required|string',
                'expiration_date' => 'required|date',
                'provider_id' => 'required|integer|exists:providers,id',
                'governments_id' => 'required|integer|exists:governments,id',
                'sub_specialization_id' => 'required|integer|exists:sub_specializations,id',
            ]);

            $job = new Job();
            $job->job_title = $request->job_title;
            $job->job_description = $request->job_description;

            $imageName = 'images/jobs/' . time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/jobs'), $imageName);
            $job->image = $imageName;

            $job->is_urgent = $request->is_urgent;
            $job->start_price = $request->start_price;
            $job->end_price = $request->end_price;
            $job->salary_type = $request->salary_type;
            $job->contract_type = $request->contract_type;
            $job->years_of_experience = $request->years_of_experience;
            $job->gender = $request->gender;
            $job->qualifications = $request->qualifications;
            $job->key_responsibilities = $request->key_responsibilities;
            $job->skill_and_experience = $request->skill_and_experience;
            $job->job_skills = $request->job_skills;
            $job->job_location = $request->job_location;
            $job->expiration_date = $request->expiration_date;
            $job->provider_id = $request->provider_id;
            $job->governments_id = $request->governments_id;
            $job->sub_specialization_id = $request->sub_specialization_id;
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
            $jobs = Job::select(
                'jobs.id',
                'jobs.job_title',
                'jobs.job_description',
                'jobs.image',
                'jobs.is_urgent',
                'jobs.start_price',
                'jobs.end_price',
                'jobs.salary_type',
                'jobs.contract_type',
                'jobs.years_of_experience',
                'jobs.gender',
                'jobs.qualifications',
                'jobs.key_responsibilities',
                'jobs.skill_and_experience',
                'jobs.job_skills',
                'jobs.job_location',
                'jobs.expiration_date',
                'providers.id as provider_id',
                'users.name as provider_name',
                'users.email as provider_email',
                'users.phone as provider_phone',
                'users.country_code as provider_country_code',
                'countries.name_ar as country_name_ar',
                'countries.name_en as country_name_en',
                'countries.flag as country_flag',
                'governments.name_ar as government_name_ar',
                'governments.name_en as government_name_en',
                'specializations.name_ar as specialization_name_ar',
                'specializations.name_en as specialization_name_en',
                'sub_specializations.name_en as specialization_name',
                'sub_specializations.name_ar as specialization_name_ar',
                'jobs.created_at',
                'jobs.updated_at'
            )
                ->join('providers', 'providers.id', '=', 'jobs.provider_id')
                ->join('users', 'providers.user_id', '=', 'users.id')
                ->join('governments', 'governments.id', '=', 'jobs.governments_id')
                ->join('countries', 'governments.country_id', '=', 'countries.id')
                ->join('sub_specializations', 'sub_specializations.id', '=', 'jobs.sub_specialization_id')
                ->join('specializations', 'sub_specializations.parent_id', '=', 'specializations.id')
                ->where('jobs.id', $id)
                ->first();

            if (!$jobs) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Not found.',
                    ],
                    404
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Job fetched successfully.',
                'data' => $jobs,
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
                'job_title' => 'nullable|string|max:255',
                'job_description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5000',
                'is_urgent' => 'nullable|boolean',
                'start_price' => 'nullable|numeric',
                'end_price' => 'nullable|numeric',
                'salary_type' => 'nullable|in:monthly,weekly',
                'contract_type' => 'nullable|in:full_time,part_time,hourly',
                'years_of_experience' => 'nullable',
                'gender' => 'nullable|in:male,female,both',
                'qualifications' => 'nullable|string',
                'key_responsibilities' => 'nullable|string',
                'skill_and_experience' => 'nullable|string',
                'job_skills' => 'nullable|string',
                'job_location' => 'nullable|string',
                'expiration_date' => 'nullable|date',
                'governments_id' => 'nullable|integer|exists:governments,id',
                'sub_specialization_id' => 'nullable|integer|exists:sub_specializations,id',
            ]);

            $job = Job::findOrFail($id);
            $job->job_title = $request->job_title;
            $job->job_description = $request->job_description;

            if ($request->hasFile('image')) {
                if ($job->image) {
                    if (file_exists(public_path($job->image))) {
                        unlink(public_path($job->image));
                    }
                }
                $imageName = 'images/jobs/' . time() . '.' . $request->image->extension();
                $request->image->move(public_path('images/jobs'), $imageName);
                $job->image = $imageName;
            }

            $job->is_urgent = $request->is_urgent ?? $job->is_urgent;
            $job->start_price = $request->start_price;
            $job->end_price = $request->end_price;
            $job->salary_type = $request->salary_type;
            $job->contract_type = $request->contract_type;
            $job->years_of_experience = $request->years_of_experience;
            $job->gender = $request->gender;
            $job->qualifications = $request->qualifications;
            $job->key_responsibilities = $request->key_responsibilities;
            $job->skill_and_experience = $request->skill_and_experience;
            $job->job_skills = $request->job_skills;
            $job->job_location = $request->job_location;
            $job->expiration_date = $request->expiration_date;
            $job->governments_id = $request->governments_id;
            $job->sub_specialization_id = $request->sub_specialization_id;
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
            if ($job->image) {
                if (file_exists(public_path($job->image))) {
                    unlink(public_path($job->image));
                }
            }
            $job->delete();
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
}
