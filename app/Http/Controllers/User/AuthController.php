<?php

namespace App\Http\Controllers\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{

/*================================== Start User Login Functions ===========================================*/

    public function index(){
        return view('website.login.login');
    }

    public function checklogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'pass' => 'required|string',
        ]);
        $credentials = [
            'username' => $request->input('username'),
            'password' => $request->input('pass'),
        ];
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('user/dashboard/index');
        }
        $errors = [];
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            $errors['username'] = 'Invalid username';
        } else {
            $errors['pass'] = 'Invalid password';
        }
        return back()->withErrors($errors)->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('index')->with('status', 'You logout successfully!');
    }
/*================================== End User Login Functions ===========================================*/

}
   