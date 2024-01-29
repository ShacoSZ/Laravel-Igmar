<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\Mail;
use App\Mail\SecondFactor; // Import the necessary class
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function index() //This is the main page
    {
        return view('Index');
    }
    public function Register() //This is the register page
    {
        return view('register');
    }
    public function Login() //This is the login page
    {
        return view('Log_In');
    }

    public function CreateUser(Request $request) //This is the function to create a new user
    {
        $validacion = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'g-recaptcha-response' => ['required', new ReCaptcha],
            ]); //This is the validation of the fields

            if($validacion->fails()){
                return redirect('register')->withErrors($validacion);
            } //This is when the validation fails

            $Fisrt_Check = User::All()->count(); //This is to check if the user is the first one to register
            if($Fisrt_Check == 0)//This is when there's no users in the database, the first user will be an admin
            {
                $user = new User();
                $user -> name = $request->name;
                $user -> email = $request->email;
                $user -> password = Hash::make($request->password);
                $user -> role_id = 1;
                $user -> status = false;
                $time = now();

                if($user->save())
                {
                    Log::info('New Admin User Register: ' . $user->name . ' (' . $user->email . ') , Time:('.$time.')');
                    return redirect()->route('index');
                }
            }
            else//This is when there's already a user in the database, the new user will be a normal user
            {
                $user = new User();
                $user -> name = $request->name;
                $user -> email = $request->email;
                $user -> password = Hash::make($request->password);
                $user -> role_id=2;
                $user -> status =false;
                $time = now();

                if($user->save())
                {
                    Log::info('New Regular User Register: ' . $user->name . ' (' . $user->email . ') , Time:('.$time.')');
                    return redirect()->route('index');
                }
            }
    }
    public function LoginUser(Request $request)//This is the function to login
    {
        $validacion = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
                'g-recaptcha-response' => ['required', new ReCaptcha],
            ]);//this is the validation of the fields

            if($validacion->fails()){
                return redirect('login')->withErrors($validacion);
            }//This is when the validation fails

            $credentials = $request->only('email', 'password');//Takes the email and password from the request and creates a variable for the credentials
            if (Auth::attempt($credentials)) //Attempt to log in when the credentials and are correct and match correctly
            {
                $user = User::where('email', $request->email)->first();//search the user in the database from his email
                if($user->role_id != 1)//check if the user is an admin or not
                {
                    Auth::login($user);
                    $time = now();
                    Log::info('User: ' . $user->name . ' (' . $user->email . ') has logged in. , Time:('.$time.')');
                    return redirect()->route('UserHome');
                }
                else //if the user is an admin, go to the second factor of verification
                {
                $verificationCode = mt_rand(100000, 999999); //generate a random code of six digits
                $user->two_factor_code = $verificationCode; //save the code in the database with the admin wants to get in
                $user->two_factor_expires_at = now()->addMinutes(10); //save the time when the code will expire
                $user->save(); //save the changes in the database
                $time = now();

                $url = URL::temporarySignedRoute('verify', now()->addMinutes(10), ['user' => $user->id]); //create a temporary url with the code
                Log::info('User Admin: ' . $user->name . ' (' . $user->email . ') passed first Authentication Phase. , Time:('.$time.')');
                Mail::to($user->email)->send(new SecondFactor($user,$url)); //send the email with the code to the admin
                return redirect($url);//go to the page where the admin will put the code
            }
            }
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]); //if the credentials are wrong, return to the login page with an error
    }

    public function logout(Request $request) //This is the function to logout
    {
        $user=Auth::user(); //get the user
        $time = now();  
        Log::info('User: ' . $user->name . ' (' . $user->email . ') has logged out. , Time:('.$time.')');
        Auth::logout(); //logout the user
        $request->session()->invalidate(); //invalidate the session
        $request->session()->regenerateToken(); //regenerate the token
        return redirect()->route('index'); //return to the main page
    }
    
    public function test(Request $request) //This is the test page
    {
        $user = Auth::user();
        $user->status=true;
        return dd($request->user());
    }
}
