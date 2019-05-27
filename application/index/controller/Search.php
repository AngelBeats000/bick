<?php
namespace app\index\controller;
use app\index\model\Article;

class Search extends Common
{
    public function index()
    {
    	
        $article=new Article();
       
        //热门文章
        $hotArticle=$article->getHotArticle();
        
        // dump($posArr);die;
        
        //搜索
        $keywords=input('keyword');
        $seaRes=db('article')->order('click desc')->where('title','like',"%".$keywords."%")->paginate(3,false,$config=['query'=>array('keyword'=>$keywords)]);
        // dump($seaRes);die;
        $this->assign(array(
            'seaRes'=>$seaRes,
            'hotRes'=>$hotArticle,
        ));
        return view('search');
    }
}
