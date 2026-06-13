<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('user.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);

        if(Auth::attempt($request->only('email','password'))){
            $request->session()->regenerate();
            $user=Auth::user();
            if($user->role!=='penghuni'){
                Auth::logout();
                return back()->withErrors(['login'=>'Akses hanya untuk penghuni']);
            }
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors(['login'=>'Email atau password salah'])->withInput();
    }

    public function showRegister()
    {
        return view('user.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email',
            'phone'=>'required|min:10|max:15',
            'address'=>'required|string',
            'password'=>'required|min:6|confirmed'
        ]);

        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'password'=>Hash::make($request->password),
            'role'=>'penghuni'
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}