<?php

namespace Classistant\Http\Controllers;

use Carbon\Carbon;
use Classistant\Newsletter;
use Classistant\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Classistant\Http\Requests;
use Classistant\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
	
	public function lander() {
		return view('lander');
	}
	
	public function newsletter(Requests\NewsletterRequest $request) {

        $newsletter = new Newsletter();

        $newsletter->email = $request->input('email');
        $newsletter->remote_addr = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : "Undefined";
        $newsletter->http_x_forwarded_for = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : "Undefined";

        $newsletter->save();

		Mail::send('emails.newsletter', ['email' => $request->input('email')], function ($m) use ($request) {
            $m->from('hello@classistant.co.uk', 'Classistant Newsletter');

            $m->to($request->input('email'))->subject('Keeping you up to date!');
        });

        Mail::send('emails.newsletter', ['email' => $request->input('email')], function ($m) use ($request) {
            $m->from('hello@classistant.co.uk', 'Classistant Newsletter');

            $m->to("thundarkat@gmail.com")->subject('Someone signed up! ('.$request->input('email').')');
        });

		return redirect(route('lander'))->with('success', 'Thanks for signing up! You should get a confirmation email soon.');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginForm() {
        if(Auth::guest()) {
            return view('login');
        } else {
            return redirect()->intended(route('dashboard'))->with('information', 'Welcome back, '.Auth::user()->name.'!');
        }
    }

    public function login(Request $input) {

        $field = filter_var($input->input('name'), FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        if(Auth::attempt([$field => $input->input('name'), 'password' => $input->input('password')])) {
            return "true";
        } else {
            return $input->input('name');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect(route('login.form'))->with('success', 'You have successfully logged out.');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('register');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\RegisterRequest $request)
    {
        $available_sets = "luds";
        $length = 9;
        $add_dashes = true;
        $sets = array();
        if(strpos($available_sets, 'l') !== false)
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        if(strpos($available_sets, 'u') !== false)
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        if(strpos($available_sets, 'd') !== false)
            $sets[] = '23456789';
        if(strpos($available_sets, 's') !== false)
            $sets[] = '!@#$%&*?';
        $all = '';
        $password = '';
        foreach($sets as $set)
        {
            $password .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for($i = 0; $i < $length - count($sets); $i++)
            $password .= $all[array_rand($all)];
        $password = str_shuffle($password);
        if(!$add_dashes)
            return $password;
        $dash_len = floor(sqrt($length));
        $dash_str = '';
        while(strlen($password) > $dash_len) 
        {
            $dash_str .= substr($password, 0, $dash_len) . '-';
            $password = substr($password, $dash_len);
        }
        $dash_str .= $password;



        $user = new User();
        $user->name = $request->input('username');
        $user->department = "Computing";
        $user->email = $request->input('email');
        $user->password = Hash::make($dash_str);
        $user->type = "Teacher";

        if(strpos($request->input('email'), '@highbury.ac.uk')) {
            $user->expiration = Carbon::today()->addMonths(24);
        } else {
            $user->expiration = Carbon::today()->addMonths(1);
        }

        $user->tutorial = 1;
        $user->save();

        Mail::send('emails.details', ['name' => $request->input('username'), 'password' =>  $dash_str], function ($m) use ($request) {
            $m->from('hello@classistant.com', 'Classistant');

            $m->to($request->input('email'), $request->input('username'))->subject('Your Login Details!');
        }); 

		 Mail::send('emails.details', ['name' => $request->input('username'), 'password' =>  $dash_str], function ($m) use ($request) {
            $m->from('hello@classistant.com', 'Classistant');

            $m->to("thundarkat@gmail.com", $request->input('username'))->subject('Someone Registered!');
        });
		
        return redirect()->intended(route('login.form'))->with('success', 'You have registered successfully!  Your password will be sent to your email, which you set as: '.$request->input('email'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Requests\ChangePasswordRequest $input)
    {
        if(Hash::check($input->input('old-password'), Auth::user()->password)) {
            Auth::user()->password = Hash::make($input->input('password'));
            Auth::user()->save();
            return redirect(route('account.edit'))->with('success', 'Password successfully changed!');
        } else {
            return redirect(route('account.edit'))->with('error', 'Error! Incorrect old password.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        return view('system.account');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeDepartment(Request $input)
    {
        if($input->input('department') !== 0) {
            Auth::user()->department = $input->input('department');
            Auth::user()->save();
            return redirect(route('account.edit'))->with('success', 'Department successfully changed!');
        } else {
            return redirect(route('account.edit'))->with('error', 'Error! Please select a department to change too.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finishTutorial()
    {
        if(Auth::guest()) {
            return "no";
        }
        Auth::user()->tutorial = 0;
        Auth::user()->save();
        return "yes";
    }

    public function enableTutorial()
    {
        if(Auth::guest()) {
            return "no";
        }
        Auth::user()->tutorial = 1;
        Auth::user()->save();
        return "yes";
    }
}


