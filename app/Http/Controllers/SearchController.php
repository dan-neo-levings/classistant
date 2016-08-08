<?php

namespace Classistant\Http\Controllers;

use Illuminate\Http\Request;

use Classistant\Http\Requests;
use Classistant\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $searchLink = true;
        return view('system.search', compact('searchLink'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $searchLink = true;
        $previousSearch['term'] = $request->input('term');
        $finalResult = [];
        $results = collect(DB::select("SELECT `lessons`.`id`, `lessons`.`topic`, `lessons`.`subject`, `lessons`.`date`, `classes`.`name`, `users`.`name` AS `teacher`
                                FROM `lessons`
                                INNER JOIN `classes`
                                ON `lessons`.`class_id` = `classes`.`id`
                                INNER JOIN `users`
                                ON `classes`.`user_id` = `users`.`id`
                                WHERE (`lessons`.`topic` LIKE '%".$request->input('term')."%'
                                OR `lessons`.`subject` LIKE '%".$request->input('term')."%'
                                OR `classes`.`name` LIKE '%".$request->input('term')."%'
                                OR `users`.`name` LIKE '%".$request->input('term')."%')
                                AND `lessons`.`private` = '0'"))->groupBy('subject', 'teacher')->toArray();

        //$results = $results->groupBy('subject')->toArray() + $results->groupBy('teacher')->toArray();
        foreach($results as $unit => $lessons) {
            foreach($lessons as $lesson) {
                $finalResult[$unit][$lesson->teacher] = $lesson;
            }
        }

        return view('system.search', compact('finalResult', 'searchLink', 'previousSearch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchFiltered(Request $request)
    {
        $searchLink = true;

        $results = collect(DB::select("SELECT `lessons`.`id`, `lessons`.`topic`, `lessons`.`subject`, `lessons`.`date`, `classes`.`name`, `users`.`name` AS `teacher`
                                FROM `lessons`
                                INNER JOIN `classes`
                                ON `lessons`.`class_id` = `classes`.`id`
                                INNER JOIN `users`
                                ON `classes`.`user_id` = `users`.`id`
                                WHERE (`lessons`.`topic` LIKE '%".$request->input('topic')."%'
                                AND `lessons`.`subject` LIKE '%".$request->input('unit')."%'
                                AND `classes`.`name` LIKE '%".$request->input('class')."%'
                                AND `users`.`name` LIKE '%".$request->input('teacher')."%')
                                AND `lessons`.`private` = '0'"))->groupBy('teacher');

        foreach($results as $unit => $lessons) {
            foreach($lessons as $lesson) {
                $finalResult[$unit][$lesson->teacher] = $lesson;
            }
        }

        $previousSearch['topic'] =$request->input('topic');
        $previousSearch['unit'] =$request->input('unit');
        $previousSearch['class'] =$request->input('class');
        $previousSearch['teacher'] =$request->input('teacher');

        return view('system.search', compact('finalResult', 'searchLink', 'previousSearch'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
