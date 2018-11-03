<?php

namespace App\Http\Controllers;

use App\Model\Goods;
use App\Model\GoodsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoodsCategoryController extends Controller
{
    //列表
    public function index(){
        $shop_id=Auth::user()->shop_id;
        $goodsCategories =GoodsCategory::where('shop_id',$shop_id)->paginate(10);
        return view('goodsCategory/index',['goodsCategories'=>$goodsCategories]);
    }
    //添加
    public function create(){
        return view('goodsCategory/add');
    }
    public function store(Request $request){
        $shop_id=Auth::user()->shop_id;  //所属商家id登陆才能得到
        $str=str_random(20); //菜品编号 随机字符
        //验证
        $this->validate($request,[
            'name' => 'required|min:2|max:20',
        ],[
            'name.required' => '分类名不能为空',
            'name.min' => '分类名不能少于2个字',
            'name.max' => '分类名不能多于20个字',
        ]);
        //如果选默认分类,其余分类的is_selected的值为0,开启事务
        if($request->is_selected==1){
            DB::transaction(function() use($request,$shop_id,$str){
                DB::table('goods_categories')->where('shop_id',$shop_id)->update(['is_selected'=>0]);
                GoodsCategory::create([
                    'name'=>$request->name,
                    'shop_id'=>$shop_id,
                    'type_accumulation'=>$str,
                    'description'=>$request->description ?? '',
                    'is_selected'=>$request->is_selected,
                ]);
            });
        }else{
            GoodsCategory::create([
                'name'=>$request->name,
                'shop_id'=>$shop_id,
                'type_accumulation'=>$str,
                'description'=>$request->description ?? '',
                'is_selected'=>$request->is_selected,
            ]);
        }
        return redirect()->route('goodsCategory.index')->with('success','添加成功 !');
    }

    //修改
    public function edit(GoodsCategory $goodsCategory){
        return view('goodsCategory/edit',compact('goodsCategory'));
    }
    public function update(GoodsCategory $goodsCategory,Request $request){
        //验证
        $this->validate($request,[
            'name' => 'required|min:2|max:20',
        ],[
            'name.required' => '分类名不能为空',
            'name.min' => '分类名不能少于2个字',
            'name.max' => '分类名不能多于20个字',
        ]);
        if($request->is_selected==1){
            DB::transaction(function() use($request,$goodsCategory){
                DB::table('goods_categories')->where('shop_id',$goodsCategory->shop_id)->where('id','<>',$goodsCategory->id)->update(['is_selected'=>0]);
                $goodsCategory->update([
                    'name'=>$request->name,
                    'description'=>$request->description,
                    'is_selected'=>$request->is_selected,
                ]);
            });
        }else{
            $goodsCategory->update([
                'name'=>$request->name,
                'description'=>$request->description,
                'is_selected'=>$request->is_selected,
            ]);
        }

        return redirect()->route('goodsCategory.index')->with('success','修改成功');
    }

    //删除
    public function destroy(GoodsCategory $goodsCategory){
        $goods=Goods::where('category_id',$goodsCategory->id)->get();
        if(count($goods)==0){
            $goodsCategory->delete();
            return 'success';
        }else{
            return '此分类下面有商品,不能删除!';
        }

    }
}
