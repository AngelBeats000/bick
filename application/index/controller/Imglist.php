<?php
namespace app\index\controller;
use app\index\model\Article;

class Imglist extends Common
{
    public function index()
    {
    	$article=new Article();
    	$artRes=$article->getAllArticle(input('cateid'));  //全部文章
    	
        
        // dump($posArr);die;
    	$this->assign(array(
    		'artRes'=>$artRes,
    		
    	));
        return view('imglist');
    }
}
