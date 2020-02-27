<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\User;
use App\BidPackages;
use App\UserBidPackages;

use Mail;
use App\Mail\Signupwelcomemail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $email=strtolower($data['email']);        
        $email_token=base64_encode($email);

        $userdata=[
            'name' => $data['name'],
            'email' => $email,
            'user_type' => $data['user_type'],
            'password' => Hash::make($data['password']),
            'email_token' =>$email_token,
        ];

        $email_userdata=[
            'name' => $data['name'],
            'email' => $email,           
            'email_token' => $email_token
        ];

        Mail::to($email)->send(new Signupwelcomemail($email_userdata));

        return User::create($userdata);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $bid_package=BidPackages::where('amount',0)->first();

        $user_bid_packages= new UserBidPackages;
        $user_bid_packages->user_id=$user->id;
        $user_bid_packages->package_id=$bid_package->id;
        $user_bid_packages->total_bids=$bid_package->no_of_bids;
        $user_bid_packages->used_bids=0;
        $user_bid_packages->balance_bids=$bid_package->no_of_bids;
        $user_bid_packages->payment_id="Free Package";
        $user_bid_packages->status=1;
        $user_bid_packages->save();            

        \Session::flash('flash_success','Account created successfully, verify your account by your welcome mail from your mail account...');
        return redirect('/login');


        /*$this->guard()->login($user);
        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());*/
    }

    public function verify($token)
    {
        $user = User::where('email_token',$token)->first();
        $user->email_verified = 1;
        $user->save();

        \Session::flash('flash_success','Your account has verified successfully...');
        return redirect('/login');   
    }

}
