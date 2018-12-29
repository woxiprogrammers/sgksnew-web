<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\UserCities;
use \Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $credentials = $request->except('_token');
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            if($user->is_active == true){
                $userCities = UserCities::where('user_id',$user->id)->get()->toArray();
                if(count($userCities) > 0){
                    Session::put('city',(int)$userCities[0]['city_id']);
                    return redirect('/member/manage');
                }else{
                    Auth::logout();
                    $request->session()->flush();
                    $request->session()->flash('error','Cities are not assigned. Please contact to administrator to get login access');
                    return redirect('/');
                }
            }else{
                Auth::logout();
                $request->session()->flush();
                $request->session()->flash('error','User is not activated yet. Please activate user first.');
                return redirect('/');
            }
        }
        return $this->sendFailedLoginResponse($request);
    }
    public function logout(\Illuminate\Http\Request $request){
        Auth::logout();
        $request->session()->flush();
        $message="Logout Successful";
        $request->session()->flash('error', $message);
        return redirect('/');
    }

    public function changeCity(Request $request){
        try{
            if($request->has('city')){
                Session::put('city',(int)$request->city);
            }
            $status = 200;
            $response = [
                'message' => 'City Changed Successfully'
            ];
        }catch (\Exception $e){
            $data = [
                'action' => 'Change city',
                'exception' => $e->getMessage()
            ];
            Log::critical(json_encode($data));
            $status = 500;
            $response = [];
        }
        return response()->json($response,$status);
    }

}
