<?php
namespace app\admin\controller;


class Index extends Common
{
    public function index()
    {
        return view();
    }

    public function logout(){
    	session(null);
    	$this->success('退出成功!','login/index');
    }
}
