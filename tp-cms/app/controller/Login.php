<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/12/6
 * Time: 19:28
 */

namespace app\controller;


use app\model\Account;
use think\captcha\facade\Captcha;
use think\facade\Cookie;
use think\facade\Session;

class Login
{
    public function index()
    {
        //获取cookie 账户 密码
        $account=Cookie::get('account');
        $password=Cookie::get('password');
        return view('login',[
            'account' => $account,
            'password' =>$password
        ]);
    }

    public function getCaptcha()
    {
        return Captcha::create();
    }

    public function login()
    {
        if (input('?post.account')&& input('?post.password')&& input('?post.captcha')) {

            //获取传值
            $account=request()->param('account');//账号
            $password=request()->param('password');//密码
            $captcha=request()->param('captcha');//验证码
            //$state=request()->param('state');

            //验证码判断
            /*if(!captcha_check($captcha)){
                return json(['code'=>0,'msg'=>'验证码输入错误']);
            };*/

            //查找用户
            $user=Account::find($account);

            //密码判断
            if($password!=$user->password) {
                return json(['code'=>0,'msg'=>'密码输入错误']);
            }

            //设置session
            Session::set('account',$account);
            Session::set('accountType',$user->accountType);
            Session::set('userName',$user->userName);

            //设置cookie
            // 记住永久记住账号
            Cookie::forever('account',$account);
            //记住密码
            Cookie::set('password',$user->password,604800);

            return json(['code'=>1,'msg'=>'登录成功']);
        }
        return json(['code'=>0,'msg'=>'参数缺失']);
    }
}