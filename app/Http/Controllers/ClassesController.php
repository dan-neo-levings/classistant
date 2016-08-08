<?php

namespace Classistant\Http\Controllers;

use Classistant\cl;
use Classistant\Lesson;
use Illuminate\Http\Request;

use Classistant\Http\Requests;
use Classistant\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classesLink = true;

        $classes = cl::with('lessons')->where('user_id', Auth::user()->id)->get();

        if(Auth::user()->tutorial == 1) {
            Auth::user()->tutorial = 2;
            Auth::user()->save();
        }

        return view('system.classes', compact('classes', 'classesLink'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->tutorial == 2) {
            Auth::user()->tutorial = 3;
            Auth::user()->save();
        }

        $newClass = new cl();
        $newClass->name = $request->input('class_name');
        $newClass->no_of_students = $request->input('class_number');
        $newClass->user_id = Auth::user()->id;
        $newClass->save();

        return redirect()->intended(route('classes.dashboard'))->with("success", "Success! You have created the programme: ".$request->input('class_name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $lessons = cl::where('id', $request->input('id'))->get();

        return $lessons->toJson();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $class = cl::find($id);
        $class->name = $request->input('name');
        $class->no_of_students = $request->input('number');
        $class->notes = $request->input('notes');
        $class->save();

        return "success";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = cl::find($id);
        if(count($class) <= 0) {
            return redirect(route('classes.dashboard'))->with('error', 'This lesson does not exist!');
        }
        if($class->user_id == Auth::user()->id) {
            $class->destroy($id);
            return redirect(route('classes.dashboard'))->with('warning', 'You have deleted the class:\n'.$class->name);
        } else {
            return redirect(route('classes.dashboard'))->with('error', 'You do not have permission to do this!');
        }

    }
}
