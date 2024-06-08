<?php

namespace App\Http\Controllers;

use App\Models\exam;
use App\Models\PasswordReset;
use App\Models\Subject;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;




class AuthController extends Controller
{
    public function loadregister()
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        }

        if (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        }
        return view('register');
    }

    public function studentregister(Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            'email' => 'string|email|required|max:100|unique:users',
            'password' => 'string|required|confirmed|min:8',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect('/')->with('success', 'Your Registration Has Been Succesfully Completed Now you Can Login!');
    }
    public function loadlogin()
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        }

        if (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        }
        return view('login');
    }

    public function userlogin(Request $request)
    {
        $request->validate([
            'email' => 'string|email|required',
            'password' => 'string|required'
        ]);

        $usercredientials = $request->only('email', 'password');
        if (Auth::attempt($usercredientials)) {
            if (Auth::user()->is_admin == 1) {
                return redirect('/admin/dashboard');
            } else {
                return redirect('/dashboard');
            }
        } else {
            return back()->with('error', 'Username & Password is incorrect');
        }
    }

    public function loaddashboard()
    {
            $exams=exam::where('plan',0)->with('subjects')->orderBy('date','DESC')->get();
        return view('student.dashboard',['exams'=>$exams]);
    }


    public function admindashboard()
    {
        $subjects=Subject::all();
        return view('admin.dashboard',compact('subjects'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function forgetpasswordload()
    {
        return view('forget-password');
    }
    public function forgetpassword(Request $request)
    {
        try {
            $user =  User::where('email', $request->email)->get();
            if (count($user) > 0) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/reset-password?token=' . $token;

                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Please Click on below link to reset Password. ';
                Mail::send('forgetpasswordmail', ['data' => $data], function ($message) use ($data) {

                    $message->to($data['email'])->subject($data['title']);
                });
                $datetime = Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $datetime
                    ]
                );

                return back()->with('success', 'Please Check Your Mail to reset your password');
            } else {
                return back()->with('error', 'Email is not exists!');
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function resetpasswordload(Request $request)
    {
        $resetdata = PasswordReset::where('token', $request->token)->get();
        if (isset($request->token) && count($resetdata) > 0) {

            $user = User::where('email', $resetdata[0]['email'])->get();

            return view('resetpassword', compact('user'));
        } else {
            return view('404');
        }
    }

    public function resetpassword(Request $request){
        $request->validate([
            'password'=>'required|string|confirmed|min:8'
        ]);
      $user=  User::find($request->id);
      $user->password=Hash::make($request->password);
      $user->save();
      PasswordReset::where('email',$user->email)->delete();
      return "<h2>Your Password has been reset successfully</h2>";
    }
}
