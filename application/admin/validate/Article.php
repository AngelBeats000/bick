<?php
namespace app\admin\Validate;
use think\Validate;

class Article extends Validate
{
	protected $rule=[
		'title'=>'require|max:60',
		'author'=>'require|max:30',
		'keywords'=>'max:100',
		'desc'=>'max:225',
		'content'=>'require',
		'thumb'=>'image|maxsize:100',

	];

	protected $message=[
		'title.require'=>'文章标题不得为空',
		'title.max'=>'文章标题长度字符不得超过60',
		'author.require'=>'文章作者不得为空',
		'author.max'=>'文章作者长度字符不得超过30',
		'keywords.max'=>'文章关键词长度字符不得超过100',
		'desc.max'=>'文章描述不得超过225个字符',
		'content.require'=>'文章内容不得为空',
		'thumb.image'=>'缩略图格式不正确',
		'thumb.maxsize'=>'缩略图大小太大',
		
	];

	//验证场景
	protected $scene=[
		'one'=>['title','author','keywords','desc','content'],

	];

}