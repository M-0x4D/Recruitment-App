<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Events\NotificationEvent;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Repositories\RegisterRepository;
use App\Http\Requests\RegisterRequest;
use App\Http\Services\NotificationService;
use App\Listeners\SendVerifyEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{

    function __construct(protected RegisterRepository $registerRepository)
    {
    }

    public function invoke(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->registerRepository->register($request->all());
            DB::commit();
            $this->sendEmail($user);
            $message = 'User Registered';
            $this->sendNotification($user,$message);
            $this->createNotification($message);
            return response()->json([
                'message' => 'user created',
                ], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error' => $th->getMessage(),
                ], 500);
        }
    }

    function createNotification($message){
        NotificationService::createNotification(auth('api')->user(),$message);
    }

    private function sendNotification(User $user, $message){
        broadcast(new NotificationEvent($user->id,$message));
    }

    private function sendEmail($user){

        UserRegistered::dispatch($user);
    }
}
