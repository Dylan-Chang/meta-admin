<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use View;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\ItemCat;
use App\Models\ItemType;
use Input;
use Redirect;

class AttributeController extends Controller {

    protected $fields = [
        'attr_name' => '',
        'status' => 0,
        'sort_order' => 0,
        'attr_values' => '',
        'attr_input_type' => 0,
        'cat_id' =>'',
    ];

    //全部属性
    public function index() {

        $attr = Attribute::all();

        return view("admin.attribute.index", ['data' => $attr]);
    }

    /**
     * Display a listing of the resource.
     * 根据类型 查询出属性列表
     * @return \Illuminate\Http\Response
     */
    public function attrlist($id) {

        $attr = Attribute::where('cat_id', '=', $id)->get();

        return view("admin.attribute.index", ['data' => $attr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $itemType = ItemType::all();
        $data = [];
        $this->fields['attr_type'] = $itemType;
        
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        // $itemCat = ItemCat::all();

        return view("admin.attribute.create", $data);
        //    return view("admin.attribute.create",['attr' => $attr]);
    }

    /**
     * 
     */
    public function save() {
        //var_dump(Input::get('cat_id'));exit;
        $data = new Attribute;
        $data->cat_id = Input::get('cat_id');
        $data->attr_name = Input::get('attr_name');
        $data->attr_values = Input::get('attr_values');
        $data->attr_input_type = Input::get('attr_input_type');
        $data->attr_type = 0;
       // var_dump($data);exit;
        $data->save();
    //    return redirect()->route('admin.attribute.index');
        return Redirect::to('admin/itemtype/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
