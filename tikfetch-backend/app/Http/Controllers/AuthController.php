<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
class AuthController extends Controller {
 public function loginForm(){return view('auth.login');}
 public function registerForm(){return view('auth.register');}
 public function register(Request $r){$d=$r->validate(['name'=>'required|string|max:100','email'=>'required|email|max:255|unique:users,email','password'=>'required|string|min:12|confirmed']);$user=User::create($d);event(new Registered($user));Auth::login($user);$r->session()->regenerate();return redirect()->route('dashboard');}
 public function login(Request $r){$d=$r->validate(['email'=>'required|email','password'=>'required|string']);if(!Auth::attempt($d)){return back()->withErrors(['email'=>'Invalid credentials.']);}if($r->user()->status!=='active'){Auth::logout();return back()->withErrors(['email'=>'Account suspended.']);}$r->session()->regenerate();return redirect()->intended(route('dashboard'));}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/');}
}
