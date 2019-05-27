<?php
namespace app\index\controller;
use app\index\model\Article;

class Artlist extends Common
{
    public function index()
    {
    	$article=new Article();
    	$artRes=$article->getAllArticle(input('cateid'));  //全部文章
    	$hotRes=$article->getHotRes(input('cateid'));  //热门文章
        
        // dump($posArr);die;
    	$this->assign(array(
    		'artRes'=>$artRes,
    		'hotRes'=>$hotRes,
    	));
        return view('artlist');
    }
}
