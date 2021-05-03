<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $user = User::where('email', $request->input('email'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return redirect(route('login'))->withErrors([
                    'login' => 'Email or password is incorrect!'
                ])->withInput();
            }

            Auth::login($user);

            return redirect('/dashboard');
        }

        return view('auth/login');
    }

    public function register(Request $request)
    {
        //TODO
        if ($request->isMethod('post')) {
            //validate request
            //create user
            // login user or send activate email
            //redirected to dashboard/login
            $this->validate(request(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
                // 'current_password' => 'required'
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // $user = new User();
            // $user->name = $request->name;
            // $user->email = $request->email;
            // $user->password =  Hash::make($request->password);
            // $user->verification_code = sha1(time());
            // $user->save(); 
        //    dd($user);
           
        // if($user != null){
        //     MailController::sendRegistrationEmail($user->name, $user->email, $user->verification_code);
        //     return redirect()->back()->with(session()->flash('alert-success', 'Your account has been created. Please check email for verification link.'));
        // }

        // return redirect()->back()->with(session()->flash('alert-danger', 'Something went wrong!'));
        
           
        
            return redirect('/dashboard');
            // dd($user);
        }
        

        //return view register
        return view('auth/register');
    }


}