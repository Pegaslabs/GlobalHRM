<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB, View;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
    	/*
    	 * 
    	 */
    	$jobsByFunction = DB::table('tblJobs')
    					->join('tblSkills', 'tblJobs.job_function_id','=','tblSkills.id')
    					->leftjoin('tblJobTitles', 'tblJobs.title_id','=','tblJobTitles.id')
    					->groupBy('tblJobs.job_function_id')
    					->select(DB::raw('COUNT(tblJobs.id) AS jobCnt, tblSkills.*, tblJobTitles.name AS titleName'))
    					->get();
    				
        return View::make('home')->with('jobsByFunction',$jobsByFunction);
        		
    }
}