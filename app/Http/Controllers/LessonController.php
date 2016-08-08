<?php

namespace Classistant\Http\Controllers;

use Classistant\cl;
use Classistant\Lesson;
use Classistant\Stage;
use Illuminate\Http\Request;

use Classistant\Http\Requests;
use Classistant\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function create($id = 0)
    {
        $classes = cl::where('user_id', Auth::user()->id)->get();
        $subjects = Lesson::distinct()->select('subject')->get();
        $selectedId = $id;

        if(Auth::user()->tutorial == 3) {
            Auth::user()->tutorial = 4;
            Auth::user()->save();
        }

        if(count($subjects) <= 0) {
            return redirect(route('classes.dashboard'))->with('error', 'You need to make a class/programme before you can do that!');
        }

        return view('system.new-lesson', compact('classes', 'subjects', 'selectedId'));
    }

    public function createFromId($id)
    {

        $classes = cl::where('user_id', Auth::user()->id)->get();
        $subjects = Lesson::distinct()->select('subject')->get();
        $baseLesson = Lesson::with('stages')->find($id);
        $selectedId = 0;
        return view('system.new-lesson', compact('classes', 'subjects', 'selectedId', 'baseLesson'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $available_sets = "lud";
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

        if(Auth::user()->tutorial == 4) {
            Auth::user()->tutorial = 5;
            Auth::user()->save();
        }

        $newLesson = new Lesson();

        $newLesson->subject = $request->input('subject');
        $newLesson->topic = $request->input('topic');
        $newLesson->date = $request->input('date');
        $newLesson->class_id = $request->input('class');
        $newLesson->objectives = $request->input('objectives');
        $newLesson->notes = $request->input('notes');
        $newLesson->time_start = $request->input('startTime');
        $newLesson->time_end = $request->input('endTime');
        $newLesson->room = $request->input('room');
        $newLesson->private = 0;

        $newLesson->secret_key = $dash_str;

        $newLesson->save();

        for($i = 0; $i < count($request->input('stage_name')); $i++) {
            $newStage = new Stage();

            $newStage->stage = $request->input('stage_name')[$i];
            $newStage->activity = $request->input('activities')[$i];
            $newStage->resources = $request->input('resources')[$i];
            $newStage->intensity = 0;
            $newStage->order_no = $i;
            $newStage->lesson_id = $newLesson->id;

            $newStage->save();
        }

        return redirect()->intended(route('classes.dashboard'))->with('success', 'You have created this lesson successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $lessons = Lesson::where('class_id', $request->input('class_id'))->where('subject', $request->input('topic'))->orderBy('date', 'desc')->get();

        $lessons[0]->time_end = (parent::prettyTime($lessons[0]->time_end));
        $lessons[0]->time_start = (parent::prettyTime($lessons[0]->time_start));
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
        $classes = cl::where('user_id', Auth::user()->id)->get();
        $subjects = Lesson::distinct()->select('subject')->get();

        $lesson = Lesson::where('id', $id)->get();

        $lesson[0]->time_end = (parent::prettyTime($lesson[0]->time_end));
        $lesson[0]->time_start = (parent::prettyTime($lesson[0]->time_start));
        $lesson_stages = Stage::where('lesson_id', $id)->get();

        return view('system.edit-lesson', compact('classes', 'subjects', 'lesson', 'lesson_stages'));
    }

    public function copyFromId($id) {
        $lesson = Lesson::find($id);
        $lessonCopy = $lesson->replicate();

        $lessonCopy->date = $lessonCopy->date->addDays(7);
        $lessonCopy->topic = $lessonCopy->topic . " (Copy)";

        $lessonCopy->push();

        $lesson_stages = Stage::where('lesson_id', $id)->get();
        foreach($lesson_stages as $stage) {
            $copiedStage = new Stage();
            $copiedStage->stage = $stage->stage;
            $copiedStage->activity = $stage->activity;
            $copiedStage->resources = $stage->resources;
            $copiedStage->intensity = 0;
            $copiedStage->order_no = $stage->order_no;
            $copiedStage->lesson_id = $lessonCopy->id;

            $copiedStage->save();
        }

        return redirect()->route('classes.dashboard')->with('success', "Lesson successfully copied!" );
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
        $updateLesson = Lesson::where('id', $id)->first();

        $updateLesson->subject = $request->input('subject');
        $updateLesson->topic = $request->input('topic');
        $updateLesson->date = $request->input('date');
        $updateLesson->class_id = $request->input('class');
        $updateLesson->objectives = $request->input('objectives');
        $updateLesson->notes = $request->input('notes');
        $updateLesson->time_start = $request->input('startTime');
        $updateLesson->time_end = $request->input('endTime');
        $updateLesson->room = $request->input('room');
        $updateLesson->private = $request->input('private') == 'on' ? "1" : "0";

        $updateLesson->save();

        Stage::where('lesson_id' ,$updateLesson->id)->delete();

        for($i = 0; $i < count($request->input('stage_name')); $i++) {
            $updateStage = new Stage();

            $updateStage->stage = $request->input('stage_name')[$i];
            $updateStage->activity = $request->input('activities')[$i];
            $updateStage->resources = $request->input('resources')[$i];
            $updateStage->intensity = 0;
            $updateStage->order_no = $i;
            $updateStage->lesson_id = $updateLesson->id;

            $updateStage->save();
        }

        return redirect()->intended(route('lesson.edit', ['id' => $updateLesson->id]))->with('success', 'Lesson successfully saved!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $lesson = Lesson::with('cl.user')->find($id);
        if(count($lesson) <= 0) {
            return redirect(route('classes.dashboard'))->with('error', 'This lesson does not exist!');
        }
        if($lesson->cl->user->id == Auth::user()->id) {
            Stage::where('lesson_id' , $id)->delete();
            $lesson->destroy($id);
            return redirect(route('classes.dashboard'))->with('warning', 'You have deleted the lesson:\n'.$lesson->topic);
        } else {
            return redirect(route('classes.dashboard'))->with('error', 'You do not have permission to do this!');
        }
    }


    /**
     * Coverts a specified lesson into a word document
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function toWordDoc($id)
    {

        $lesson = Lesson::with('cl', 'stages')->find($id);
        $lesson->time_end = (parent::prettyTime($lesson->time_end));
        $lesson->time_start = (parent::prettyTime($lesson->time_start));
        $lesson->topic = ($lesson->topic == "") ? $lesson->subject : $lesson->topic;
        return response(view('system.toWordDoc', compact('lesson')))
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment; filename='.str_slug($lesson->topic).'.doc');
    }

    /**
     * Coverts a list of lessons into a scheme of work word document
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function schemeOfWorkGenerator($class_id, $lesson_id)
    {
        //return [$class_id, $lesson_id];

        $unit = Lesson::findOrFail($lesson_id)->subject;

        $lessons = Lesson::with('cl', 'stages')->where('subject', $unit)->owned()->where('class_id', $class_id)->orderBy('date')->get();
        //return dd($lessons[0]);

        return response(view('system.schemeOfWorkGenerator', compact('lessons')))
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment; filename='.str_slug($unit).'-scheme-of-work.doc');
    }

    public function emailLesson(Request $input) {

        Mail::send('emails.sendLesson', ['sender' => Auth::user()->name, 'link' =>  "https://classistant.co.uk/lesson/retrieve/".$input->input('id')], function ($m) use ($input) {
            $m->from('hello@classistant.com', 'Classistant');

            $m->to($input->input('email'))->subject(Auth::user()->name.' has sent you a lesson plan!');
        });
    }

    public function retrieveLesson($secret_key) {

        $lesson = Lesson::with('cl.user', 'stages')->where('secret_key', $secret_key)->first();

        $lesson->time_end = (parent::prettyTime($lesson->time_end));
        $lesson->time_start = (parent::prettyTime($lesson->time_start));
        return response(view('system.toWordDoc', compact('lesson')))
            ->header('Content-Type', 'application/vnd.ms-word')
            ->header('Content-Disposition', 'attachment; filename='.str_slug($lesson->topic).'.doc');
    }
}
