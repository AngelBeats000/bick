<?php
namespace app\admin\controller;
use app\admin\model\Login as LoginAdmin;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
    	if (request()->isPost()) {
            $this->check(input('code'));
    		$login=new LoginAdmin();
    		$num=$login->loginadmin(input('post.'));
    		if($num=='1'){
    			$this->error('用户不存在');
    		}
    		if ($num=='3') {
    			$this->error('密码错误');
    		}
    		if ($num=='2') {
              return  redirect('index/index');
    			//$this->success('登录成功！','index/index');
    		}
    		return;//如果表单提交数据，直接返回，不再加载模板
    	}
        return view('login');
    }

    public function check($code)
    {
        if (!captcha_check($code)) {
            // $this->error('验证码错误');
            return true;
        } else {
            return true;
        }
    }
}
