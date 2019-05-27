<?php
namespace app\admin\Validate;
use think\Validate;

class Cate extends Validate
{
	protected $rule=[
		'catename'=>'require|max:30|unique:cate'

	];

	protected $message=[
		'catename.require'=>'栏目名称不得为空',
		'catename.max'=>'栏目名称长度不得超过30个字符',
		'catename.unique'=>'栏目名称不得重复',
	];

	//验证场景
	protected $scene=[
		'one'=>['catename'],

	];

}