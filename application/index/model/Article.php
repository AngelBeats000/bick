<?php
namespace app\index\model;
use think\Model;
use app\index\model\Cate;

class Article extends Model
{
    //当前栏目下的文章
    public function getAllArticle($cateid){
    	$cate=new Cate();
    	$allCateId=$cate->getchilrenid($cateid);
    	$artRes=db('article')->where("cateid IN($allCateId)")->order('id desc')->paginate(9);
    	return $artRes;
    }

    //当前栏目下的热门文章
    public function getHotRes($cateid){
    	$cate=new Cate();
    	$allCateId=$cate->getchilrenid($cateid);
    	$artRes=db('article')->where("cateid IN($allCateId)")->order('click desc')->limit(6)->select();
    	return $artRes;
    }

    //获取最新文章
    public function getNewArticle(){
        $newArticleRes=db('article')->alias('a')->join('bk_cate b','a.cateid=b.id')->order('a.id desc')->limit(6)->field('a.id,a.title,a.cateid,a.thumb,a.time,a.click,a.zan,a.desc,b.catename,b.type')->select();
        return $newArticleRes;
    }

    //热门文章
    public function getHotArticle(){
        $artRes=db('article')->order('click desc')->field('id,title,thumb')->limit(6)->select();
        return $artRes;

    }

    //推荐文章
    public function getRecArticle(){
        $recArt=$this->where('rec','=','1')->order('click desc')->field('id,title,thumb')->limit(4)->select();
        return $recArt;
    }
    
}
