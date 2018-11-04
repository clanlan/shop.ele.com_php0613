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

    //注册店铺
    public function create(){
        $cates=DB::table('shop_categories')->where('status',1)->get();
        return view('user.create',compact('cates'));
    }
    //保存
    public function store(Request $request,ImageUploadHandler $uploader){

        //保存店铺图片
        $path1='';
        $path2='';
        if ($request->img1) {
            $result = $uploader->save($request->img1, 'shop','shoplogo');
            if ($result) { $path1 = $result['path']; }
        }
        //保存账号图片
        if ($request->img2) {
            $result = $uploader->save($request->img2, 'shop','shoplogo');
            if ($result) { $path2 = $result['path']; }
        }
        //开启事务
        DB::beginTransaction();
        $sql1=DB::table('shops')->insertGetId([
            'shop_category_id'=>$request->shop_category_id,
            'shop_name'=>$request->shop_name,
            'start_send'=>$request->start_send ?? '0',
            'send_cost'=>$request->send_cost ?? '0',
            'status'=>0,
            'notice'=>$request->notice,
            'discount'=>$request->discount,
            'shop_img'=>$path1,
            'brand'=>$request->brand ?? 0,
            'on_time'=>$request->on_time ?? 0,
            'fengniao'=>$request->fengniao ?? 0,
            'bao'=>$request->bao ?? 0,
            'piao'=>$request->piao ?? 0,
            'zhun'=>$request->zhun ?? 0,
        ]);
        $sql2=DB::table('users')->insert([
            'name'=>$request->name,
            'email'=>$request->email,
            'tel'=>$request->tel,
            'password'=>bcrypt($request->password),
            'shop_id'=>$sql1,
            'status'=>0,
            'img'=>$path2,
        ]);
        if($sql1 && $sql2){
            DB::commit();
            return redirect()->route('index')->with('success','注册成功!');
        }else{
            DB::rollBack();
            return back()->with('danger','注册失败!')->withInput();
        }


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
