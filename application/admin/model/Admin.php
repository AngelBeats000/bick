<?php
namespace app\admin\model;
use think\Model;

class Admin extends Model
{
    //添加数据
    public function addadmin($data){
        //如果接收的数据为空或者不是数组，false
        if(empty($data) || !is_array($data)){
            return false;
        }
        //密码md5加密
        if($data['password']){
            $data['password']=md5($data['password']);
        }
        //save添加数据操作；
        $dataAdmin=array();
        $dataAdmin['name']=$data['name'];
        $dataAdmin['password']=$data['password'];
        if ($this->save($dataAdmin)) {
            $groupAccess['uid']=$this->id;
            $groupAccess['group_id']=$data['group_id'];
            db('auth_group_access')->insert($groupAccess);
            return true;
        }else{
            return false;
        }
    }

    //查询数据
    public function getadmin()
    {
        //查询并分页
       return $this::order('id','desc')->paginate(10);
    }


    //修改数据
    public function saveadmin($data,$admins){
        if (!$data['name']) {
            return 2; //用户名为空
        }
        if (!$data['password']) {
            $data['password']=$admins['password'];
        }else{
            $data['password']=md5($data['password']);
        }
        
        db('auth_group_access')->where(array('uid'=>$data['id']))->update(['group_id'=>$data['group_id']]);
        return $this::update(['name'=>$data['name'],'password'=>$data['password']],['id'=>$data['id']]);
    }

    //删除
    public function deladmin($id)
    {
        if ($this::destroy($id)) {
            return 1;             //1删除成功，2删除失败
        }else{ 
            return 2;
        }
    }


    //

}
