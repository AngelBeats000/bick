<?php
namespace app\admin\Validate;
use think\Validate;

class Admin extends Validate
{
	protected $rule=[
		'name'=>'unique:admin|require|min:2|max:30',
		'password'=>'require|min:6',

	];

	protected $message=[
		'name.unique'=>'用户名不得重复',
		'name.require'=>'用户名不得为空',
		'name.min'=>'用户名长度最少为2个字符',
		'name.max'=>'用户名长度最长为30个字符',
		'password.require'=>'密码不得为空',
		'password.min'=>'密码长度最少为6个字符',
		
	];

	//验证场景
	protected $scene=[
		'one'=>['name','password'],
		'edit'=>['name','password'=>'min:6'],

	];

}