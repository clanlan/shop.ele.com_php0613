<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Model\Goods;
use App\Model\GoodsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodsController extends Controller
{
    //列表
    public function index(Request $request){
        $user=Auth::user();
        $cates=GoodsCategory::where('shop_id',$user->shop_id)->get();
        $wheres=[];
        $wheres[]=['shop_id',$user->shop_id];
        if($request->category_id){
            $wheres[]=['category_id',$request->category_id];
        }
        if($request->keywords){
            $wheres[]=['goods_name','like',"%{$request->keywords}%"];
        }
        if($request->min_price){
            $wheres[]=['goods_price','>',$request->min_price];
        }
        if($request->max_price){
            $wheres[]=['goods_price','<',$request->max_price];
        }
        $goods=Goods::where($wheres)->orderBy('id','desc')->paginate(10);
        if(count($goods)==0){
            return redirect()->route('goods.index')->with('danger','没有符合条件的商品');
        }
        return view('goods.index',['goods'=>$goods,'cates'=>$cates]);
    }
    //价格升序
    public function price(){
        $user=Auth::user();
        $cates=GoodsCategory::where('shop_id',$user->shop_id)->get();
        $goods=Goods::where('shop_id',$user->shop_id)->orderBy('goods_price','desc')->paginate(10);
        return view('goods.index',['goods'=>$goods,'cates'=>$cates]);
    }

    //显示
    public function show(Goods $good){
        $good->description=htmlspecialchars_decode($good->description);
        return view('goods.show',compact('good'));
    }


    //添加
    public function create(){
        $user=Auth::user();

        $cates=GoodsCategory::where('shop_id',$user->shop_id)->get();
        if(count($cates)!=0){
            return view('goods/add',compact('cates'));
        }else{
            return redirect()->route('goodsCategory.create')->with('danger','您还没有商品分类,请先添加商品分类!');
        }
    }
    public function store(Request $request,ImageUploadHandler $uploader){
        //验证数据
        $this->validate($request,[
            'goods_name'=>'required|min:2|max:50|unique:goods',
            'category_id'=>'required'
        ],[
            'goods_name.required'=>'商品名不能为空',
            'goods_name.min'=>'不能少于两个字',
            'goods_name.max'=>'最多可输入50个字',
            'goods_name.unique'=>'商品名已存在',
            'category_id.required'=>'请选择分类',
        ]);
        //如果有图
        if ($request->goods_img){
            $result = $uploader->save($request->goods_img, 'goods','goods'.$request->category_id);
            if ($result) { $path= $result['path']; }
        }else{$path='';}
        $shop_id=Auth::user()->shop_id;
        Goods::create([
            'goods_name'=>$request->goods_name,
            'category_id'=>$request->category_id,
            'goods_price'=>$request->goods_price,
            'description'=>$request->description,
            'tips'=>$request->tips,
            'goods_img'=>$path,
            'shop_id'=>$shop_id,
            'status'=>$request->status,
        ]);
        return redirect()->route('goods.index')->with('success','添加成功!');
    }

    //修改
    public function edit(Goods $good){

        $user=Auth::user();
        $cates=GoodsCategory::where('shop_id',$user->shop_id)->get();
        return view('goods.edit',['good'=>$good,'cates'=>$cates]);
    }
    public function update(Goods $good,Request $request,ImageUploadHandler $uploader){
        //验证数据
        $this->validate($request,[
            'goods_name'=>'required|min:2|max:50',
            'category_id'=>'required'
        ],[
            'goods_name.required'=>'商品名不能为空',
            'goods_name.min'=>'不能少于两个字',
            'goods_name.max'=>'最多可输入50个字',
            'category_id.required'=>'请选择分类',
        ]);
        //如果有图
        if ($request->goods_img){
            $result = $uploader->save($request->goods_img, 'goods','goods'.$request->category_id);
            if ($result) { $path= $result['path']; }
            //删除原图
            //if($good->goods_img){unlink($good->goods_img);}

            $good->update([
                'goods_name'=>$request->goods_name,
                'category_id'=>$request->category_id,
                'goods_price'=>$request->goods_price,
                'description'=>$request->description,
                'tips'=>$request->tips,
                'goods_img'=>$path,
                'status'=>$request->status,
            ]);

        }else{
            $good->update([
                'goods_name'=>$request->goods_name,
                'category_id'=>$request->category_id,
                'goods_price'=>$request->goods_price,
                'description'=>$request->description,
                'tips'=>$request->tips,
                'status'=>$request->status,
            ]);
        }
        return  redirect()->route('goods.index')->with('success','修改成功!');


    }

    //删除
    public function destroy(Goods $good){
        $good->delete();
        return 'success';
        //return redirect()->route('goods.index')->with('success','删除成功!');
    }

    //上架
    public function upsale(Goods $good){
        $good->update([
            'status'=>1
        ]);
        return 'success';
    }
    //下架
    public function downsale(Goods $good){
        $good->update([
            'status'=>0
        ]);
        return 'success';
    }
}
