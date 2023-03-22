<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\entry;
use App\Models\price;
use App\Models\stock;
use App\Models\bill;
use App\Models\purchase;
use App\Models\quatation;
use App\Models\entity;
use App\Models\purchaseReturn;
use App\Models\saleReturn;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = category::all();

        return view('admin.category',['category'=>$category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function active_category(Request $request)
    {
        $id = $request->id;
        $model = category::find($id);
        $model->status = 1;
        $model->save();
        return 1;
    }
    public function deactive_category(Request $request)
    {
        $id = $request->id;
        $model = category::find($id);
        $model->status = 0;
        $model->save();
        return 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add_category(Request $request)
    {
        $result = category::where(['category'=>$request->category])->first();
        if($result){
         return 0;
        }else{
        $model = new category;
        $model->category = $request->category;
        $model->status = 1;
        $model->save();
        return 1;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit_category(Request $request)
    {
        $id = $request->id;
        $data = category::where(['id'=>$id])->first();

        $output="<form id='update_from'>
        <div class='form-group'>
          <label for='recipient-name' class='col-form-label'>Category</label>
          <input type='text' class='form-control' id='eidt_category' name='edit_category' value='{$data->category}'>
          <input type='hidden' class='form-control' id='category_id' name='category_id' value='{$data->id}'>
        </div>

      </form>";
      return $output;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update_category(Request $request)
    {
        $id = $request->category_id;
        $model =category::find($id);
        $model->category = $request->edit_category;
        $model->save();
        return 1;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function remove_category(Request $request)
    {
        $id = $request->id;
        bill::where(['brand_id'=>$id])->delete();
        purchase::where(['branch_id'=>$id])->delete();
        stock::where(['to'=>$id])->delete();
        stock::where(['from'=>$id])->delete();
        quatation::where(['branch_id'=>$id])->delete();
        entry::where(['branch_id'=>$id])->delete();
        entity::where(['branch_id'=>$id])->delete();
        purchaseReturn::where(['branch_id'=>$id])->delete();
        saleReturn::where(['branch_id'=>$id])->delete();
        price::where(['brand_id'=>$id])->delete();
        category::where(['id'=>$id])->delete();
        return 1;
    }
}
