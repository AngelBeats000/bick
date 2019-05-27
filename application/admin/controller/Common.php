<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use think\Controller;
use think\Request;

class Common extends Controller
{
    public function _initialize()
    {
        if(!session('id') || !session('name')){
            $this->error('请先登录','login/index','',500);
        }

        $auth=new Auth();
        $request=Request::instance();
        $con=$request->controller();
        $action=$request->action();
        $name=$con.'/'.$action;            //所点击的页面
        $notCheck=array('Index/index','Admin/lst','Index/logout');   //不需要权限即可访问的页面
        if(session('id')!=1){                   //id为1的超级管理员
        	if(!in_array($name, $notCheck)){     
        		if(!$auth->check($name,session('id'))){        
       				$this->error('没有权限','index/index');
       			}
        	}
        	
        }
       	
    }
   

}
