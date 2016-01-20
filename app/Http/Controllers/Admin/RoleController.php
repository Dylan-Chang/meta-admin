<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\User;
use Input;
use DB;

class RoleController extends Controller {

    protected $fields = [
        'name' => '',
        'display_name' => '',
        'desc' => ''
    ];

    public function index() {
        $role = Role::all();
        // var_dump($item);exit;
        return view('admin.role.index', ['role' => $role]);
    }

    //
    public function softDel() {
        
    }

    public function create() {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        return view('admin.role.create', $data);
    }

    public function check() {
        $user = User::findOrFail(3);
        $rs = $user->hasRole('owner');   // false
        var_dump($rs);
        $rs = $user->hasRole('admin');   // true
        var_dump($rs);
        $rs = $user->canRole('edit-user');   // false
        var_dump($rs);
        $rs = $user->canRole('create-post'); // true
        var_dump($rs);
    }

    //分配权限
    public function assign() {
        
    }

    public function edit($id) {
        $role = Role::findOrFail($id);

        $permissions = Permission::all();
        $permission = new Permission();
        $permissionRole = $permission->permissionRole($role->id);

        return view('admin.role.edit', ['role' => $role, 'permissions' => $permissions, 'permissionRole' => $permissionRole]);
    }

    //
    public function update($id) {
        $role = Role::findOrfail($id);

        foreach (array_keys(array_except($this->fields, ['role'])) as $field) {

            $role->$field = Input::get($field);
        }

        $role->save();

        //分配权限
        $permission = new Permission();
        $permission->updateRelation($role->id);

        return redirect()->route('admin.role.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store() {
        //
        $role = new Role;
        $role->display_name = Input::get('display_name');
        $role->name = Input::get('name');
        $role->desc = Input::get('desc');
        $role->save();

        return redirect()->route('admin.role.index');
    }

    //初始化权限系统
    public function init() {
        return false;

        //分配权限
        $admin = Role::findOrFail(2);

        $user = User::where('name', '=', 'cd')->first();

// role attach alias
        $user->attachRole($admin); // parameter can be an Role object, array, or id
// or eloquent's original technique
        $user->roles()->attach($admin->id); // id only
        //添加权限
        $owner = Role::findOrFail(1);
        $admin = Role::findOrFail(2);

        $createPost = new Permission();
        $createPost->name = 'create-post';
        $createPost->display_name = 'Create Posts'; // optional
// Allow a user to...
        $createPost->description = 'create new blog posts'; // optional
        $createPost->save();

        $editUser = new Permission();
        $editUser->name = 'edit-user';
        $editUser->display_name = 'Edit Users'; // optional
// Allow a user to...
        $editUser->description = 'edit existing users'; // optional
        $editUser->save();

        $admin->attachPermission($createPost);
// equivalent to $admin->perms()->sync(array($createPost->id));

        $owner->attachPermissions(array($createPost, $editUser));
    }

}
