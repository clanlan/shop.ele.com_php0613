<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Model\Shop;
use App\Model\ShopCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    //添加店铺
    public function create(User $user){
        //获取店铺分类
        $shopCategory=ShopCategory::where('status',1)->get();
        return view('user.addShop',compact('user','shopCategory'));
    }
    //保存店铺
    public function store(User $user,Request $request,ImageUploadHandler $uploader){
        //验证数据
        $this->validate($request,[
            'shop_name'=>'required|unique:shops',
            'shop_category_id'=>'required',
        ],[
            'shop_name.required'=>'店铺名不能为空',
            'shop_name.unique'=>'店铺名已存在',
            'shop_category_id.required'=>'请选择店铺分类'
        ]);

        //接收图片 保存图片 shopCategory文件夹名 shopcate图片文件名
        if ($request->img) {
            $result = $uploader->save($request->img, 'shop','shoplogo');
            if ($result) {
                $path = $result['path'];
            }
        }else{$path='';}
        //开启事务
        DB::beginTransaction();
        try{
            $shop=Shop::create([
                'shop_category_id'=>$request->shop_category_id,
                'shop_name'=>$request->shop_name,
                'start_send'=>$request->start_send ?? '0',
                'send_cost'=>$request->send_cost ?? '0',
                'status'=>0,
                'notice'=>$request->notice,
                'discount'=>$request->discount,
                'shop_img'=>$path,
                'brand'=>$request->brand ?? 0,
                'on_time'=>$request->on_time ?? 0,
                'fengniao'=>$request->fengniao ?? 0,
                'bao'=>$request->bao ?? 0,
                'piao'=>$request->piao ?? 0,
                'zhun'=>$request->zhun ?? 0,
            ]);
            $result=$user->update([
                'shop_id'=>$shop->id,
            ]);
            DB::commit();
            return redirect()->route('login')->with('success','店铺'.$request->name.'申请成功,请耐心等待管理员审核!');
        }catch (\Exception $e) {
            DB::rollBack();
        }

    }
}
