<?php
namespace App\Http\Controllers;
use App\User;
use Redirect;
use View;

/**
 * 用户管理
 * @author HP
 *
 */
class UserController extends Controller{
    
    public function index(){
        //查找用户
        $user = User::all();
        return view('user.index', ['user' => $user]);
    }
    
    public function create() {
        return View::make("user/create");
    }
    
    public function save(){
        
    }
    
    public function edit(){
        
    }
}