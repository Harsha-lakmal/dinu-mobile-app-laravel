<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AnuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return response()->json([
                'status'  => 'success',
                'message' => 'Login successful!',
                'redirect_url' => url('/dashboard')
            ]);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }


    public function showRegister()
    {
        return view('auth.register');
    }


    public function getUserData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $validator->validated()['email'];

        $user = User::where('email', $email)->first();

        if ($user) {
            return response()->json($user);
        }

        return response()->json(['message' => 'User not found'], 404);
    }


    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'TelNumber' => 'required|string|max:15|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'TelNumber' => $request->TelNumber,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/login')->with('success', 'Account created successfully!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status'  => 'success',
            'message' => 'You have been logged out successfully.',
            'redirect_url' => url('/login')
        ]);
    }
public function changePassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'current_password' => 'required',
        'new_password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['error' => 'Current password is incorrect'], 400);
    }

    DB::table('users')
        ->where('id', $user->id)
        ->update([
            'password' => Hash::make($request->new_password),
            'updated_at' => now(), 
        ]);

    return response()->json(['success' => 'Password changed successfully!']);
}

function deleteAccount(Request $request)
{

    
    $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    DB::table('users')->where('id', $user->id)->delete();

    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json(['success' => 'Account deleted successfully!']);

}

}
