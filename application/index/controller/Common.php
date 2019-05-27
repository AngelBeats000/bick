<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Conf;
use app\index\model\Cate;

class Common extends Controller
{ 
    public function _initialize()
    {   
        //当前位置
        if (input('cateid')) {
            $this->getPos(input('cateid'));                         //如果是列表
        }
        if (input('artid')) {
            $article=db('article')->field('cateid')->find(input('artid'));          //如果是文章

            $cateid=$article['cateid'];
            $this->getPos($cateid);
            
        }
        $this->getConf();       //网站配置
        $this->getAllCates();   //二级菜单
    }
    

    //二级菜单
    public function getAllCates(){
        header("Content-Type:text/html;charset=utf-8");
        $cateres=db('cate')->where(array('pid'=>0))->select();  //查找顶级栏目
        foreach ($cateres as $k => $v) {
            $children=db('cate')->where(array('pid'=>$v['id']))->select();             //根据顶级栏目查找子栏目
            if ($children) {          //如果子栏目存在，就把子栏目与顶级栏目组成二维数组
                $cateres[$k]['children']=$children;
            }else{
                $cateres[$k]['children']=0;
            }
        }
          //  dump($cateres);die;
        $this->assign('cateres',$cateres);
    }

    public function getConf(){
        $conf=new Conf();
        $_confres=$conf->getAllConf();
        $confres=array();
        foreach ($_confres as $k => $v) {
            $confres[$v['enname']]=$v['value'];
        }
        //dump($confres);die;
        $this->assign('confres',$confres);
    }

    public function getPos($cateid)
    {
        $cate=new Cate();
        $posArr=$cate->getparents($cateid);    //当前位置
        $this->assign('posArr',$posArr);
    }
}
