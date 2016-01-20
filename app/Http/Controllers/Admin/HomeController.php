<?php
namespace App\Http\Controllers\Admin;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use App\Http\Controllers\Controller;

class HomeController extends Controller{
    
    public function index(){
        return view('admin.index');
    }
}
