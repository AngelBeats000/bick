<?php
namespace app\index\controller;

class Page extends Common
{
    public function index()
    {
    	$article=db('cate')->where('id',input('cateid'))->find();
    	//dump($article);die;
    	$this->assign('page',$article);
        return view('page');
    }
}
