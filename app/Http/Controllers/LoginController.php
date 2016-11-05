<?php namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use DB;
use Auth;
use Mail;
use Hash;
use Exception;
use App\Traits\UserTrait;
use App\Models\UserEmailVerify;
use App\Models\User;

DB::connection()->enableQueryLog();

class LoginController extends Controller {

    use UserTrait;
    
    /**
     * Instantiate a new controller instance.
     */
    public function __construct() {

    }

    /**
     *  show login form and register form
     *  @return mixed view
     */
    public function showLogin(Request $request) {

        if(Auth::check()) {//if already login then redirct to dashboard
            return redirect()->to('dashboard');
        }

        return View('layouts.login');
    }

    /**
     *  post data for login
     * @param request object $request
     * @return mixed
     */
    public function postLogin(Request $request) {
        $this->validate($request, [
                                    'username' => 'required',
                                    'password' => 'required'
                                    ]
                    );
        $username = $request->get("username");
        $password = $request->get("password");
        $remember = ($request->has('remember')) ? true : false;
        if (Auth::attempt(array('email' => $username, 'password' => $password, 'status'=>'active', 'email_verify'=>'1'), $remember)) {
            //update last login
            try {
                User::updateLastLogin(Auth::user());    
            } catch (Exception $e) {
                //return false;
            }
            
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with('signinMsg', 'Invalid credentials');

    }

    /* register a user
     * @param request object $request
     * @return mixed
     */
    public function postRegister(Request $request) {
        $validator = Validator::make($request->all(), array(
                'email' => 'required|email|unique:users',
                'firstname' => 'required',
                'lastname' => 'required',
            )
        );
        if ($validator->fails()) {
            foreach($validator->errors()->getMessages() as $msg) {
                $msgArr[] =  $msg[0];
            }
            return redirect()->back()->withInput()->with('signupMsg', implode("<br>", $msgArr));
        }    
        
        $email = $request->get("email");
        $firstname = $request->get("firstname");
        $lastname = $request->get("lastname");

        //make verification code
        $verificationCode = uniqid();
        //save user
        try {
            $userObj = app()->make("\App\Models\User");
            $userObj->email = $email;
            $userObj->name = $firstname. " ".$lastname;
            $userObj->status = "pending";
            $userObj->created_at = date("Y-m-d H:i:s");
            $userObj->save();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('signupMsg', 'Error in save');
        }
                
        if ($userObj) {
            $userId = $userObj->id;
            //save usr email verify
            $emailVData=[
                "user_id"=>$userId,
                "verification_code"=>$verificationCode
            ];
            
            $verifyObj = UserEmailVerify::saveData($emailVData);

            ///send email
            $userData = array('email' => $email, "fullname" => $firstname . " " . $lastname);
            Mail::send('emails.emailverify', array("verificationCode" => $verificationCode, "email" => $email), function ($message) use ($userData) {
                $message->from(config('mail.from.address'), ucwords(config('mail.from.name')));
                $message->to($userData['email'], $userData['fullname'])
                    ->subject(config('app.siteName').' Account Activation');
            });

            return redirect()->back()->with('signupSuccessMsg', "You have successfully registered and mail has been sent for activation.");
        } else {
            $msg =  "User creation failure.";
        }

        return redirect()->back()->withInput()->with('signupMsg', $msg);
    }
    
    /*
     *  Activate account and change password form view
     *  @param  string $verificationCode
     *  @return views
     * 
     */
    public function activateUser(Request $request, $verificationCode) {
        //Clear session to signout if any user already logged in
        Auth::logout();
        //check code if exists then view reset form
        $objExists = $this->getEmailVerifyByCode( $verificationCode);
        
        if ($objExists) {
            $userObj = $objExists->user;
            if ($userObj->status == "pending" && $userObj->email_verify == "0") {
                return View('layouts.resetpwd', compact('verificationCode'));
            } else {
                $msg = "Your account has already been verified";
            }
        } else {
            $msg = "Invalid code";
        }
        return redirect()->route('login')->with('signinMsg', $msg);
    }

    /*  change password
     * @param request object $request
     * @return mixed
     */
    public function resetPwd(Request $request) {
        $this->validate($request, [
                                    'verificationCode' => 'required',
                                    'password' => 'required|min:8|max:25',
                                    'cpassword' => 'required|same:password'
                                    ]
        );

        $pwdStrength = $this->checkPasswordStrenth($request->get("password"));
        if ($pwdStrength == 0) {
            $msg =  "Password must be one upper and lower case, one number and one special chars.";
            return redirect()->back()->withInput()->with('pwdMsg', $msg);
        }
        
        //check code if exists then update user password
        $objExists = $this->getEmailVerifyByCode( $request->get('verificationCode'));
        
        if ($objExists) {
            $userObj = $objExists->user;
            try {
                $userObj->email_verify = 1;
                $userObj->status = 'active';
                $userObj->password = Hash::make($request->get('password'));
                $userObj->save();    
                //remove this code from table
                $objExists->delete();

            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('pwdMsg', "Error in update, Please consult admin");
            }

            //rediect to login page
            return redirect()->route("login")->with('signupSuccessMsg', "Your account has been activated, you may now login.");
        }       
        
    }

}
