<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    //登陆
    public function login(){
        return view('/login');
    }
    //验证登录状态
    public function store(Request $request){
        $user=User::where('name',$request->name)->first();
        if(!isset($user)){
            return redirect()->route('login')->with('danger','账号不存在,请先注册! ')->withInput();
        }else{
            if($user->status==1){
                if(Auth::attempt(['name'=>$request->name,'password'=>$request->password],$request->has('remember'))){
                    return redirect()->intended(route('index'))->with('success',$request->name.'欢迎回来!');
                }else{
                    return back()->with('danger','用户名或密码错误')->withInput();
                }
            }else{
                return redirect()->route('login')->with('danger','店铺审核中,请耐心等待!')->withInput();
            }
        }
    }
    //退出登陆
    public function destroy(){
        Auth::logout();
        return redirect()->route('index')->with('success','退出成功！');

    }


}
