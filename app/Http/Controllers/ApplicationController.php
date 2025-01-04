<?php

namespace App\Http\Controllers;

use App\Http\Enums\ApplicationStatusEnum;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApplicationController extends Controller
{
    public function index()
    {
        // Code to list all applications
    }

    public function create()
    {
        // Code to show form for creating a new application
    }

    public function apply(Request $request)
    {
        try {
            DB::beginTransaction();
            $application = Application::create([
                'user_id' => auth('api')->id(), // Assume user is authenticated
                'job_id' => $request->job_id,
                'status'=> ApplicationStatusEnum::Pending,
                'applied_at' => Carbon::now(),
            ]);
            $this->upload($request->file('resume'),$application);
            DB::commit();
            return response()->json(['message' => 'Application submitted successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function upload($file,$application)
{
    // Store the file
    $path = $file->store('uploads');

    // Store file record with expiration time and ownership
    File::create([
        'path' => $path,
        'expires_at' => Carbon::now()->addDays(30), // Set expiration to 30 days
        'user_id' => auth('api')->id(), // Assume user is authenticated
        'application_id' => $application->id,
    ]);

    return response()->json(['message' => 'File uploaded successfully']);
}

    public function show($id)
    {
        // Code to show a single application
    }

    public function edit($id)
    {
        // Code to show form for editing an application
    }

    public function update(Request $request, $id)
    {
        // Code to update an application
    }

    public function destroy($id)
    {
        // Code to delete an application
    }
}
