<?php
namespace app\index\controller;
use app\index\model\Article;

class Index extends Common
{
    public function index()
    {
    	//最新文章调用
    	$article=new Article();
    	$newArticle=$article->getNewArticle();
    	
    	//热门文章
    	$hotArticle=$article->getHotArticle();

    	//友情链接
    	$link=db('link')->order('sort desc')->select();
    	
    	//推荐文章
    	$recArt=$article->getRecArticle();
    	// dump($_SERVER['PHP_SELF']);die;
    	
    	$this->assign(array(
    		'newArticle'=>$newArticle,
    		'hotRes'=>$hotArticle,
    		'link'=>$link,
    		'recArt'=>$recArt,

    	));
        return view();
    }
}

