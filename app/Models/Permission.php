<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;
use DB;
use Input;

class Permission extends EntrustPermission {

    // protected $table = 'Permission';
    //角色下的权限
    public function permissionRole($id) {
        $permissionRole = DB::table('permission_role')->where('role_id', $id)->select('permission_id')->get();
        //  array_values($permissionRole);
        $data = array();
        foreach ($permissionRole as $value) {
            $data[$value->permission_id] = $value->permission_id;
        }
        return $data;
    }

    //更新关联
    public function updateRelation($rid) {
        $permissions = Input::get('permissions');
        
        /* Delete old. */
        DB::table('permission_role')->where('role_id', $rid)->delete();

        /* Insert new. */
        foreach ($permissions as $value) {
            DB::table('permission_role')->insert(
                    ['permission_id' => $value, 'role_id' => $rid]
            );
        }
    }

}
