<?php namespace App\Http\Controllers;

use Auth;
use App\Http\Controllers\Controller;
use Input;
use App\Models\Log;
use Redirect;
use Lang;
use Illuminate\Http\Request;

class LoginController extends Controller {

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $email = Input::get('email');
        $password = Input::get('password');
        $remember = Input::get('remember');
        if (Auth::attempt(['email' => $email, 'password' => $password],$remember))
        {
			Log::create(['action' => '登录系统','userid'=>Auth::user()->id,'username'=>Auth::user()->name]);
                        return redirect()->intended('orders');
        }
        
        
        return Redirect::to('/auth/login')->with('errors' , array($this->loginUsername() => '用户名或密码错误'));
    }
    
     public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/auth/login';
    }
    
     /**
     * Get the failed login message.
     * 获取登录失败消息
     * @return string
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
                ? Lang::get('auth.failed')
                : '用户名或密码错误';
    }
    
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }

}