<?php

namespace App\Http\Controllers;

use App\Events\NotificationEvent;
use App\Http\Requests\StoreJobRequest;
use App\Http\Services\NotificationService;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = Job::all();
        return response()->json($jobs);
    }

    /**
     * Store a newly created job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobRequest $request)
    {
        try {
            DB::beginTransaction();
            $message  = 'User Registered';
            $data = $request->all();
            $data['salary'] = (double) $request->salary;
            Job::create($data);
            $this->createNotification($message);
            DB::commit();
            $this->sendNotification(auth('api')->user(), $message);
            return response()->json(['message' => 'Job created successfully']);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return response()->json(['message'=> $th->getMessage()]);
        }
    }

    function createNotification($message){
        NotificationService::createNotification(auth('api')->user(),$message);
    }

    private function sendNotification(User $user, $message){
        broadcast(new NotificationEvent($user->id,$message));
    }


}
