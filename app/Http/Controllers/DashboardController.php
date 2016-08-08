<?php

namespace Classistant\Http\Controllers;

use Carbon\Carbon;
use Classistant\Lesson;
use Illuminate\Http\Request;

use Classistant\Http\Requests;
use Classistant\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dashboardLink = true;
        $userId = Auth::user()->id;
        $beginningWeek = Carbon::today()->startOfWeek();
        $nextWeek = Carbon::today()->endOfWeek();
        $thisWeeksLessons = Lesson::with('cl')->where('date', '>=', $beginningWeek)
                                              ->where('date', '<=', $nextWeek)
                                              ->owned()
                                              ->orderBy('date')
                                              ->orderBy('time_start', 'desc')
                                              ->orderBy('time_end')
                                              ->get()->groupBy(function($item)
                                                {
                                                    return $item->date->format('l, jS F');
                                                });
        foreach($thisWeeksLessons as $key => $lessons) {
            foreach($lessons as $lesson) {
                $lesson->time_end = (parent::prettyTime($lesson->time_end));
                $lesson->time_start = (parent::prettyTime($lesson->time_start));
            }
        }
        return view('dashboard-index', compact('dashboardLink', 'thisWeeksLessons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
