<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use App\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    public function verify(Request $request)
    {

        $userId = $request->route('id');
        $user = User::findOrFail($userId);

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));


            DB::table('user_data_flow')->insert([
                'id_user' => $userId,
                'id_matchday' => 0,
                'points_total' => 0,
                'position' => $this->getNewPosition(),
                'points_matchday' => 0
            ]);
        }


        return redirect($this->redirectPath())->with('verified', true);
    }

    private function getNewPosition() {
        return DB::table('user_data_flow')->max('position') + 1;
    }
}
