<?php
namespace app\index\controller;
use app\index\model\Article as ArticleModel;

class Article extends Common
{
    public function index()
    {
    	$artid=input('artid');
    	db('article')->where(array('id'=>$artid))->setInc('click',1);
    	$article=db('article')->find($artid);

    	$articleRes=new ArticleModel();
    	$hotRes=$articleRes->getHotRes($article['cateid']);			//热门文章

    	$this->assign(array(
    		'article'=>$article,
    		'hotRes'=>$hotRes,
    	));
        return view('article');
    }
}
