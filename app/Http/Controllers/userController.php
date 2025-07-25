<?php

namespace App\Http\Controllers;
use view;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



class userController extends Controller
{
    // Show Register/Create Form

    public function create(){
        return view('users.register');
    }

    //Create New User

    public function store(Request $request){
    $formFields = $request->validate([
        'name' =>['required', 'min:3'],
        'email'=>['required','email', Rule::unique('users', 'email')],
        'password'=>'required|confirmed|min:6',

    ]);

    //hash password

    $formFields['password'] = bcrypt($formFields['password']);

    //create user
    $user = User::create($formFields);

    //Login

    auth()->login($user);

    return redirect('/')->with('message','User Created and logged in');

    }

    //Logout user

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','You have been logout!');
    }


    //Show login form

    public function login(){

        return view('users.login');
    }

    //Authenticate user

    public function authenticate(Request $request){

       $formFields = $request->validate([
        'email'=>['required','email'],
        'password'=>'required'
    ]);

    if(auth()->attempt($formFields)){

        $request->session()->regenerate();

        return redirect('/')->with('message','You are now logged in!');
    }

    return back('/')->withErrors(['email' => 'Invalid Credentials!'])->onlyInput('email');

    }

}
