<?php
namespace app\index\model;
use think\Model;
class Cate extends Model
{
  	


    public function getchilrenid($cateid){
        $cateres=$this->select();
      	$arr=$this->_getchilrenid($cateres,$cateid);
      	$arr[]=$cateid;
      	$strId=implode(',', $arr);
        return $strId;
    }
           //$cateres为查找到的全部数据
            //$cateid为当前要删除的栏目的id
            //修改时也用_getchilrenid此方法来查询要修改栏目的所有子栏目
    public function _getchilrenid($cateres,$pid){
         static $arr=array(); //定义静态数组
         foreach ($cateres as $k => $v) {          
             if ($v['pid']==$pid) {         //查找pid等于当前要删除的栏目的id的项，然后把该项的id赋给$arr[];
                     
                 $arr[]=$v['id'];
                 $this->_getchilrenid($cateres,$v['id']);  // 递归调用，查找出所有的子项
                 
             }
         }
         return $arr;  //返回要删除栏目id的所有子栏目id
    }


    public function getparents($cateid){
        $cateres=$this->field('id,pid,catename')->select();
        $cates=db('cate')->field('id,pid,catename')->find($cateid);
        $pid=$cates['pid'];
        if($pid){
          $arr=$this->_getparents($cateres,$pid);
        }
        $arr[]=$cates;
        return $arr;
    }
          
    public function _getparents($cateres,$pid){
         static $arr=array(); //定义静态数组
         foreach ($cateres as $k => $v) {          
             if ($v['id']==$pid) {         //查找pid等于当前要删除的栏目的id的项，然后把该项的id赋给$arr[];
                     
                 $arr[]=$v;
                 $this->_getparents($cateres,$v['pid']);  // 递归调用，查找出所有的父项
                 
             }
         }
         return $arr;  //返回要删除栏目id的所有子栏目id
    }


}
