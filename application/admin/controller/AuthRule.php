<?php
namespace app\admin\controller;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\controller\Common;

class AuthRule extends Common
{
  



  public function lst(){
  	$authRule=new AuthRuleModel();
  	$authRuleRes=$authRule->authRuleTree();
  	$this->assign('authRuleRes',$authRuleRes);
  	return view('list');
  }


  public function add(){
  	if (request()->isPost()) {
  		$data=input('post.');
  		$plevel=db('auth_rule')->where('id',$data['pid'])->field('level')->find();
  		if($plevel){
  			$data['level']=$plevel['level']+1;
  		}else{
  			$data['level']=0;
  		}
  		$add=db('auth_rule')->insert($data);
  		if ($add) {
  			$this->success('新增成功', 'lst');
  		}else{
  			$this->error('新增失败');
  		}
  		
  		return;
  	}

  	$authRule=new AuthRuleModel();
  	$authRuleRes=$authRule->authRuleTree();
  	$this->assign('authRuleRes',$authRuleRes);
  	
  	return view();
  }


  public function edit(){

  	if (request()->isPost()) {
  		$data=input('post.');
  		$plevel=db('auth_rule')->where('id',$data['pid'])->field('level')->find();
  		if($plevel){
  			$data['level']=$plevel['level']+1;
  		}else{
  			$data['level']=0;
  		}
  		$edit=db('auth_rule')->update($data);
  		if ($edit!==false) {
  			$this->success('修改权限成功', 'lst');
  		}else{
  			$this->error('修改权限失败');
  		}
  		return;
  	}

  	$authRule=new AuthRuleModel();
  	$authRuleRes=$authRule->authRuleTree();//无线级栏目

  	$authRules=$authRule->find(input('id'));

  	$noids=$authRule->getchilrenid(input('id'));//子栏目的id。修改时当前栏目不能修改为当前栏目下的子栏目


  	$this->assign(array(
  		'authRuleRes'=>$authRuleRes,
  		'authRules'=>$authRules,
  		'noids'=>$noids,
  	));
  	
  	return view();
  }

  public function del(){
	  $authRule=new AuthRuleModel();
  	$authRuleIds=$authRule->getchilrenid(input('id'));//把子栏目赋给变量
  	$authRuleIds[]=input('id');              //把当前项赋给数组
  	$del=AuthRuleModel::destroy($authRuleIds);    //删除多项，
  	if ($del) {
  		$this->success('删除成功', 'lst');
  	}else{
  		$this->error('删除失败');
  	}
  }


}
