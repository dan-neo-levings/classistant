<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'lander', 'uses' => 'AuthController@lander']);
Route::post('/newsletter', ['as' => 'newsletter', 'uses' => 'AuthController@newsletter']);
Route::get('/login', ['as' => 'login.form', 'uses' => 'AuthController@loginForm']);
Route::post('/login', ['as' => 'login.attempt', 'uses' => 'AuthController@login']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
Route::get('/register', ['as' => 'register', 'uses' => 'AuthController@create']);
Route::post('/register', ['as' => 'register.store', 'uses' => 'AuthController@store']);

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', ['as' => 'password.reset', 'uses' => 'Auth\PasswordController@postReset']);

Route::group(['middleware' => 'auth'], function() {

    //DASHBOARD LINK
    Route::get('dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    //CRUD CLASSES
    Route::get('classes', ['as' => 'classes.dashboard', 'uses' => 'ClassesController@index']);
    Route::post('classes', ['as' => 'classes.store', 'uses' => 'ClassesController@store']);
    Route::post('classes/update/{id}', ['as' => 'classes.update', 'uses' => 'ClassesController@update']);
    Route::get('classes/destroy/{id}', ['as' => 'classes.destroy', 'uses' => 'ClassesController@destroy']);

    //JSON REQUESTS
    Route::post('classes/get', ['as' => 'classes.get', 'uses' => 'ClassesController@show']);
    Route::post('lesson/get', ['as' => 'lesson.get', 'uses' => 'LessonController@show']);

    //LESSON CREATES
    Route::get('lesson/new', ['as' => 'lesson.create', 'uses' => 'LessonController@create']);
    Route::get('lesson/newFromId/{id}', ['as' => 'lesson.createFromId', 'uses' => 'LessonController@createFromId']);
    Route::get('lesson/new/{id}', ['as' => 'lesson.create', 'uses' => 'LessonController@create']);
    Route::post('lesson/new', ['as' => 'lesson.store', 'uses' => 'LessonController@store']);

    //LESSON EDIT, COPY, UPDATE, DELETE
    Route::get('lesson/edit/{id}', ['as' => 'lesson.edit', 'uses' => 'LessonController@edit']);
    Route::get('lesson/copy/{id}', ['as' => 'lesson.copyFromid', 'uses' => 'LessonController@copyFromId']);
    Route::post('lesson/update/{id}', ['as' => 'lesson.update', 'uses' => 'LessonController@update']);
    Route::get('lesson/destroy/{id}', ['as' => 'lesson.destroy', 'uses' => 'LessonController@destroy']);

    //DOCUMENT GENERATORS
    Route::get('wordGenerator/lessonPlan/{id}', ['as' => 'lesson.generateDoc', 'uses' => 'LessonController@toWordDoc']);
    Route::get('wordGenerator/schemeOfWork/{class_id}/{lesson_id}', ['as' => 'generateDoc.schemeOfWork', 'uses' => 'LessonController@schemeOfWorkGenerator']);

    //UPDATING ACCOUNTS
    Route::get('account', ['as' => 'account.edit', 'uses' => 'AuthController@edit']);
    Route::post('account/changePassword', ['as' => 'account.changePassword', 'uses' => 'AuthController@changePassword']);
    Route::post('account/changeDepartment', ['as' => 'account.changeDepartment', 'uses' => 'AuthController@changeDepartment']);
    Route::post('account/finishTutorial', ['as' => 'account.finishTutorial', 'uses' => 'AuthController@finishTutorial']);
    Route::post('account/enableTutorial', ['as' => 'account.enableTutorial', 'uses' => 'AuthController@enableTutorial']);

    //SEARCH FUNCTIONS
    Route::get('search', ['as' => 'search', 'uses' => 'SearchController@index']);
    Route::post('search', ['as' => 'search.term', 'uses' => 'SearchController@search']);
    Route::post('search/filtered', ['as' => 'search.term.filtered', 'uses' => 'SearchController@searchFiltered']);

    //EMAIL LESSON
    Route::post('lesson/send', ['as' => 'lesson.send', 'uses' => 'LessonController@emailLesson']);

    //ADD STUDENTS
    Route::post('classes/addStudent', ['as' => 'students.addToClass', 'uses' => 'StudentsController@addToClass']);
    //Route::post('classes/removeStudent', ['as' => 'students.addToClass', 'uses' => 'StudentsController@addToClass']);
});

Route::get('lesson/retrieve/{secret_key}', ['as' => 'lesson.retrieve', 'uses' => 'LessonController@retrieveLesson']);
