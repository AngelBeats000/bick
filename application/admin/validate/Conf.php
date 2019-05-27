<?php
namespace app\admin\Validate;
use think\Validate;

class Conf extends Validate
{
	protected $rule=[
		'cnname'=>'unique:conf|require|max:60',
		'enname'=>'unique:conf|require|alpha|max:60',


	];

	protected $message=[
		'cnname.unique'=>'中文名称不得重复',
		'cnname.require'=>'中文名称不得为空',
		'cnname.max'=>'中文名称长度不得超过60个字符',
		'enname.unique'=>'英文名称不得重复',
		'enname.require'=>'英文名称不得为空',
		'enname.alpha'=>'英文名称必须是英文',
		'enname.max'=>'英文名称长度不得超过60个字符',


	];

	//验证场景
	protected $scene=[
		'one'=>['cnname','enname'],

	];

}