<?php
namespace app\admin\Validate;
use think\Validate;

class AuthGroup extends Validate
{
	protected $rule=[
		'title'=>'require|max:30|unique:auth_group'

	];

	protected $message=[
		'title.require'=>'栏目名称不得为空',
		'title.max'=>'栏目名称长度不得超过30个字符',
		'title.unique'=>'栏目名称不得重复',
	];

	//验证场景
	protected $scene=[
		'one'=>['title'],

	];

}