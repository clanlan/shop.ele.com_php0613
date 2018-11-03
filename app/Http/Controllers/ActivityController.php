<?php

namespace App\Http\Controllers;

use App\Model\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    //列表
    public function index(){
        $activities=Activity::where('end_time','>',date('y-m-d h:i:s',time()))->orderBy('start_time','desc')->paginate(10);
        return view('activity.index',['activities'=>$activities]);
    }
    //查看
    public function show(Activity $activity){
        return view('activity/show',compact('activity'));
    }

}
