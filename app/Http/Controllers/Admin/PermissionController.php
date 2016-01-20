<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\User;
use Input;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PermissionController extends Controller {
  protected $fields = [
        'name' => '',
        'display_name' => '',
        'desc' => ''
    ];
    
    public function index() {
        $permission = Permission::all();
        return view('admin.permission.index', ['permission' => $permission]);
    }

    public function create() {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view('admin.permission.create', $data);
    }

    public function edit($id) {
        $data = Role::findOrFail($id);
        return view('admin.permission.edit', $data);
    }

    //
    public function update($id) {
        $data = Permission::findOrfail($id);

        foreach (array_keys(array_except($this->fields, ['permission'])) as $field) {
            $data->$field = Input::get($field);
        }
        //   get_class($role);
        $data->save();

        return redirect()->route('admin.permission.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store() {
        //
        $data = new Permission;
        $data->display_name = Input::get('display_name');
        $data->name = Input::get('name');
        $data->desc = Input::get('desc');
        $data->save();

        return redirect()->route('admin.permission.index');
    }

}
