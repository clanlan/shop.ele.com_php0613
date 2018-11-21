<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth',[
            'except'=>['create','store']
        ]);
    }

    //注册商家
    public function create(){
        return view('user.create');
    }
    //保存
    public function store(Request $request,ImageUploadHandler $uploader){
        //验证数据
        $val=$this->validate($request, [
            'name' => 'required|min:3|max:20',
            'email' => 'email|unique:users',
            'tel' => [
                'required',
                'regex:/^1[3-9]\d{9}$/',
                'unique:users'
            ],
            'password' => [
                'required',
                'regex:/^\w{6,16}$/',
                'confirmed'
            ],
            'password_confirmation' => 'required|same:password',
        ],[
            'name.required' => '用户名不能为空',
            'name.min' => '用户名不能少于三位',
            'name.max' => '用户名不能多于20位',
            'email.email' => '邮箱格式不正确',
            'email.unique' => '此邮箱已存在',
            'tel.required' => '手机号不能为空',
            'tel.regex' => '手机号格式不正确',
            'tel.unique' => '电话号码已存在',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => "密码与确认密码不匹配",
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
        ]);
        if($val==false){ return back()->withInput();}
        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名
        if ($request->img) {
            $result = $uploader->save($request->img, 'shopusre','user');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'tel'=>$request->tel,
            'password'=>bcrypt($request->password),
            'shop_id'=>0,
            'status'=>0,
            'img'=>$path,
        ]);

        return redirect()->route('shop.create',compact('user'))->with('success','请完成店铺信息');
    }

    //修改
    public function edit(){}
    //更新
    public function update(){}
    //显示
    public function show(){}
    //修改密码
    public function resetpwd(){
        $user=Auth::user();
        return view('user/resetpwd',compact('user'));
    }
    public function updatepwd(User $user,Request $request){
        //验证
        $this->validate($request,[
            'oldpassword'=>'required',
            'password' => ['required', 'regex:/^\w{6,16}$/', 'confirmed','different:oldpassword'],
            'password_confirmation' => 'required|same:password',
        ],[
            'oldpassword.required' => '请输入旧密码',
            'password.required' => '请输入密码',
            'password.regex' => '6-16为密码.可以是数字,字母或下划线',
            'password.confirmed' => '密码与确认密码不一致',
            'password.different' => '新密码不能和旧密码相同',
            'password_confirmation.required' => "确认密码不能为空",
            'password_confirmation.same' => '',
        ]);

        if(Hash::check($request->oldpassword, $user->password)){
            $user->update([ 'password'=>bcrypt($request->password),]);
            Auth::logout(); //修改成功后退出登陆
            return redirect()->route('login')->with('success','密码修改成功！请重新登陆');
        }else{
            return back()->withInput()->with('danger','修改密码失败!');
        }
    }

}
