<?php

namespace App\Http\Controllers\Auth;

use App\Events\NotificationEvent;
use App\Http\Controllers\Controller;
use App\Http\Repositories\LoginRepository;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    function __construct(protected LoginRepository $loginRepository)
    {
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function invoke(LoginRequest $request)
    {
        $user = $this->loginRepository->attemptLogin($request->validated());
        $message = 'User Logged In';
        $this->sendNotification($user, $message);
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json([
            // 'user' => $user,
            'token' => $token,
        ]);
    }

    private function sendNotification(User $user, $message){
        broadcast(new NotificationEvent($user->id,$message));
    }
}
