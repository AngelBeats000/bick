<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{
   

    //查询数据
    public function catetree()
    {
        //查询并分页
       $cateres=$this->order('sort desc')->select();   //select默认表为文件名cate
       return $this->sort($cateres,$pid=0,$level=0);
    }
    //排序
    public function sort($data,$pid=0,$level=0){
        static $arr=array(); //定义静态数组
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){     //找到pid,即上级栏目为0的，该项为顶级栏目
                $v['level']=$level;    //顶级栏目level为0
                $arr[]=$v;             //赋给数组
                $this->sort($data,$v['id'],$level+1);   //递归调用，然后找出pid为顶级栏目id的项，level+1，正则
                
            }
        }
        return $arr;
    }

            
    public function getchilrenid($cateid){
        $cateres=$this->select();
        return $this->_getchilrenid($cateres,$cateid);
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


}
