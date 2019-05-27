<?php
namespace app\admin\model;
use think\Model;
class AuthRule extends Model
{
   

   //查询数据
    public function authRuleTree()
    {
        //查询并分页
       $authruleres=$this->select();   //select默认表为文件名
       return $this->sort($authruleres);
    }
    //排序
    public function sort($data,$pid=0){
        static $arr=array(); //定义静态数组
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){     //找到pid,即上级栏目为0的，该项为顶级栏目

                $v['dataid']=$this->getparentid($v['id']);
                $arr[]=$v;             //赋给数组
                $this->sort($data,$v['id']);   //递归调用，然后找出pid为顶级栏目id的项，正则
                
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


 //查询父权限id 主要用于AuthGroup
     public function getparentid($authRuleid){
        $authRuleres=$this->select();
        return $this->_getparentid($authRuleres,$authRuleid,True);
    }
           //$cateres为查找到的全部数据
            //$cateid为当前要删除的栏目的id
            //修改时也用_getchilrenid此方法来查询要修改栏目的所有子栏目
    public function _getparentid($authRuleres,$authRuleid,$clear=False){
         static $arr=array(); //定义静态数组
         if ($clear) {
            $arr=array();
         }
         foreach ($authRuleres as $k => $v) {          
             if ($v['id']==$authRuleid) {         //查找pid等于当前要删除的栏目的id的项，然后把该项的id赋给$arr[];
                     
                 $arr[]=$v['id'];
                 $this->_getparentid($authRuleres,$v['pid'],False);  // 递归调用，查找出所有的子项
                 
             }
         }
        
         asort($arr);
         $arrStr=implode('-',$arr);
         return $arrStr;  //返回要删除栏目id的所有子栏目id
    }






}
