<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Log;
use Auth;
use Hash;
use Storage;
use Setting;
use Exception;
use Notification;
use Mail;

use App\User;
use App\BidPackages;
use App\UserBidPackages;
use App\Http\Controllers\Auth\LoginController;
use App\Mail\Signupwelcomemail;


class UserApiController extends Controller
{
    public function signup(Request $request)
    {
        $this->validate($request, [                
                'device_type' => 'required|in:android,ios',
                'device_token' => 'required',
                'device_id' => 'required',
                'name' => 'required|regex:/^[a-zA-Z ]+$/u|max:255',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6',
            ]);

        try{

            $User = $request->all();
            $email=strtolower($request['email']);            
            $User['email'] = $email;
            $User['password'] = bcrypt($request->password);
            $User['user_type'] = 1;
            $e_token=base64_encode($email);
            $User['email_token'] = $e_token;
            $User = User::create($User);

            $userdata1=[
                    'name' => $User['name'],
                    'email' => $email,
                    'password' => $User['password'],
                    'email_token' => $e_token,
                    'ip' => $User['ip'],
            ];

            $bid_package=BidPackages::where('amount',0)->first();

            $user_bid_packages= new UserBidPackages;
            $user_bid_packages->user_id=$User->id;
            $user_bid_packages->package_id=$bid_package->id;
            $user_bid_packages->total_bids=$bid_package->no_of_bids;
            $user_bid_packages->used_bids=0;
            $user_bid_packages->balance_bids=$bid_package->no_of_bids;
            $user_bid_packages->status=1;
            $user_bid_packages->save();   

            Mail::to($email)->send(new Signupwelcomemail($userdata1));

            return $User;

        } catch (Exception $e) {
             return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }


    public function logout(Request $request)
    {
        try {
            User::where('id', $request->id)->update(['device_id'=> '', 'device_token' => '']);
            return response()->json(['message' => trans('api.logout_success')]);
        } catch (Exception $e) {
            return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }    

    public function forgot_password(Request $request){

        $this->validate($request, [
                'email' => 'required|email|exists:users,email',
            ]);

        try{  
            
            $user = User::where('email' , $request->email)->first();

            if($user){
                                
                $email_token=app('auth.password.broker')->createToken($user);
                $user->email_token = $email_token;
                $user->save();

                Notification::send($user, new AccountResetPassword($email_token));

                return response()->json([
                    'message' => 'Reset link has sent to your email!',
                    'user' => $user
                ]);
            }else{
                return response()->json(['error' => "Invalid mail address, Please Check at once.."], 500);
            }

        }catch(Exception $e){
                return response()->json(['error' => trans('api.something_went_wrong')], 500);
        }
    }    
}