<?php
namespace app\admin\model;
use think\Model;

class Login extends Model
{
	public function loginadmin($data){
		$admin=Admin::getByName($data['name']);
		if($admin){
			if ($admin['password']==md5($data['password'])) {
				session('id',$admin['id']);
				session('name',$admin['name']);
				return 2; //登录成功
			}else{
				return 3;//用户名正确，密码错误；
			}
		}else{
			return 1; //用户名不存在
		}
	}

}