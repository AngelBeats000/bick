<?php
namespace app\admin\Validate;
use think\Validate;

class Link extends Validate
{
	protected $rule=[
		'title'=>'require|max:60|unique:link',
		'url'=>'url|require|max:160|unique:link',
		'desc'=>'max:225'


	];

	protected $message=[
		'title.require'=>'标题不得为空',
		'title.max'=>'标题长度字符不得超过60',
		'title.unique'=>'链接标题不得重复',
		'url.require'=>'链接地址不得为空',
		'url.max'=>'链接地址长度不得超过60',
		'url.unique'=>'链接地址不得重复',
		'url.url'=>'链接地址格式不正确',
		'desc.max'=>'链接描述字符长度不得超过225',
	];

	//验证场景
	protected $scene=[
		'one'=>['title','url'=>'url|require|max:160|unique:link','desc'],
		'two'=>['title','url','desc'],

	];

}