<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobApplicationController extends Controller
{
    public function apply(Request $request)
    {
        try {
            $request->validate([
                'job_id' => 'required|integer|exists:jobs,id',
                'years_of_experience' => 'required|integer|min:0',
                'cover_letter' => 'nullable|string',
                'resume' => 'nullable|file|mimes:pdf,doc,docx',
                'skills' => 'nullable|string',
                'available_to_start_date' => 'nullable|date',
                'expected_salary' => 'nullable|integer|min:0',
                'why_ideal_candidate' => 'nullable|string',
            ]);


            // التحقق من الحد الأقصى اليومي للتقديمات
            $client = Client::where('user_id', auth()->id())->first();
            $dailyApplications = JobApplication::where('client_id', $client->id)
                ->whereDate('created_at', today())
                ->count();

            if ($dailyApplications >= 5) { // العدد الأقصى للتقديمات اليومية
                return response()->json(['message' => 'You have reached your daily application limit'], 403);
            }

            $application = new JobApplication();
            $application->client_id = $client->id;
            $application->job_id = $request->job_id;
            $application->years_of_experience = $request->years_of_experience;
            $application->cover_letter = $request->cover_letter;
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('files/job_applications'), $fileName);
                $application->resume = 'files/job_applications/' . $fileName;
            }
            $application->skills = $request->skills;
            $application->available_to_start_date = $request->available_to_start_date;
            $application->expected_salary = $request->expected_salary;
            $application->why_ideal_candidate = $request->why_ideal_candidate;
            $application->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Application submitted successfully',
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

    public function clientApplications(Request $request)
    {
        try {
            $request->validate([
                'client_id' => 'required|integer|exists:clients,id',
                'status' => 'nullable|in:pending,accepted,rejected',
            ]);

            $applications = DB::table("client_job_application_view")
                ->where('client_id', $request->client_id)
                ->when($request->status, function ($query) use ($request) {
                    return $query->where('application_status', $request->status);
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Applications retrieved successfully',
                'data' => $applications,
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

    public function jobApplications(Request $request)
    {
        try {
            $request->validate([
                'job_id' => 'required|integer|exists:jobs,id',
            ]);

            $applications = DB::table("client_job_application_view")
                ->where('job_id', $request->job_id)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Applications retrieved successfully',
                'data' => $applications,
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

    public function destroy(string $id)
    {
        try {
            $application = JobApplication::findOrFail($id);
            if ($application->resume) {
                if (file_exists(public_path($application->resume))) {
                    unlink(public_path($application->resume));
                }
            }
            $application->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Application deleted successfully.',
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

    public function updateStatus(Request $request, string $id)
    {
        try {
            $request->validate([
                'status' => 'required|in:pending,accepted,rejected',
            ]);

            $application = JobApplication::findOrFail($id);
            $application->status = $request->status;
            $application->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Application status updated successfully.',
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