<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\WebUsers;

class WebUsersController extends Controller
{
    public function index()
    {
        return response(view('auth.login'))->withCookie('user_name', 'My name is Khan', 1);
    }

    public function signup()
    {
        if (session()->has('user_name'))
            return redirect('dashboard');
        return view('auth.signup');
    }
    public function forgot()
    {
        $name = request()->cookie('user_name');
        return view('auth.forgot')->with('user_name', $name);
    }
    public function reset()
    {
        return view('auth.reset');
    }
    public function saveUser(Request $request)
    {
        $user = WebUsers::where('email', $request->email)->first();
        if ($user != null) {
            return response()->json([
                "user_exist" => 'Email id taken!!'
            ]);
        }
        if ($request->password != $request->conf_password) {
            return response()->json([
                "no_match" => 'Confirm password does not match!!'
            ]);
        }
        $user = new WebUsers;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        // $user->password = Hash::make($request->password);

        if ($request->image != null && isset($request->image)) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('users'), $imageName);
            $user->image = $imageName;
        }

        $user->save();
        return response()->json([
            "message" => 'Registered successfully'
        ]);
    }
    public function loginUser(Request $request)
    {
        // print_r($_POST);
        $user = WebUsers::where('email', $request->email)->first();
        if ($user == null) {
            return response()->json([
                "user_not_exist" => 'New user!!'
            ]);
        }
        if ($request->password != $user->password) {
            return response()->json([
                "wrong_password" => 'Password is wrong!!'
            ]);
        }
        $request->session()->put('user_name', $user->name);
        $request->session()->put('user_email', $user->email);
        $request->session()->put('user_image', $user->image);
        return response()->json([
            "success" => "Successfully logged in"
        ]);

    }
    public function dashboard()
    {
        $data = ["userData" => WebUsers::where('email', session('user_email'))->first()];
        return view('dashboard', $data);
    }
    public function logout()
    {
        if (session()->has('user_name')) {
            session()->flush();
            return redirect('/');
        }
        return redirect('/signup');
    }
    public function imageUpdate(Request $request)
    {
        // print_r($_FILES);
        // print_r($_POST);
        $user_id = $request->user_id;
        $user = WebUsers::where('id', $user_id)->first();

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('users'), $imageName);

            if ($user->image != 'default_image.jpg') {
                Storage::delete('users/' . $user->image);
            }

            $user->image = $imageName;
            $user->update();
            return response()->json([
                'success' => "Profile image updated"
            ]);
        }

        return response()->json([
            'fail' => "Profile image couldn't be updated"
        ]);
    }
    public function updateInfo(Request $request)
    {
        $user_id = $request->user_id;
        $user = WebUsers::where('id', $user_id)->first();
        if ($user->name == $request->name) {
            return response()->json([
                'fail' => "Nothing to update"
            ]);
        }
        $user->name = $request->name;
        $user->update();
        return response()->json([
            'success' => "Name updated"
        ]);
    }
    public function resetEmail(Request $request)
    {
        $user = WebUsers::where('email', $request->email)->first();
        if ($user == null) {
            return response()->json([
                'not_registered' => "Email not registered"
            ]);
        }
        $token = Str::uuid();
        $details = [
            'body' => route('reset', ['email' => $request->email, 'token' => $token])
        ];

        $user->update([
            'token' => $token,
            'token_expire' => Carbon::now()->addMinutes(10)->toDateTimeString()
        ]);
        Mail::to($request->email)->send(new ForgotPassword($details));
        return response()->json([
            'success' => "Email sent!!"
        ]);
    }
}
