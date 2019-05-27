<?php
namespace app\admin\controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\controller\Common;
use app\admin\model\AuthRule as AuthRuleModel;
class AuthGroup extends Common
{
   public function lst(){
   		$AuthGroupRes=AuthGroupModel::paginate(10);
   		$this->assign('authgroupRes',$AuthGroupRes);

   		return view('list');
   }

   public function add(){
   	if (request()->isPost()) {
   		$data=input('post.');
   		if (input('status')) {
   			$data['status']=1;
   		}

         if($data['rules']){
            $data['rules']=implode(',',$data['rules']);
         }
         
         //验证规则
         $validate = \think\Loader::validate('AuthGroup');
         if(!$validate->scene('one')->check($data)){
             $this->error($validate->getError());
         }

   		$add=db('auth_group')->insert($data);
   		//dump($data);
   		//die;
   		if($add){
   			$this->success('新增成功', 'lst');
   		}else{
   			$this->error('新增失败');
   		}
   	}


   $AuthGroups=new AuthRuleModel();
   $AuthGroupRes=$AuthGroups->authRuleTree();
   $this->assign('AuthGroupRes',$AuthGroupRes);
   	return view();
   }

   public function del(){
      
   		$del=db('auth_group')->delete(input('id'));
   		if ($del) {
   			$this->success('删除用户组成功', 'lst');
   		}else{
   			$this->error('删除用户组失败');
   		}
   }

   public function edit(){
   		if (request()->isPost()) {
   			$data=input('post.');
   			if (input('status')) {
   				$data['status']=1;
   			}else{
   				$data['status']=0;
   			}

            if($data['rules']){
               $data['rules']=implode(',',$data['rules']);
            }

            //验证规则
            $validate = \think\Loader::validate('AuthGroup');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }

   			$edit=db('auth_group')->update($data);
   			if ($edit!==false) {
   				$this->success('修改用户组成功', 'lst');
   			}else{
   				$this->error('修改用户组失败');
   			}
   			return;
   		}
         $AuthGroups=new AuthRuleModel();
         $AuthGroupRes=$AuthGroups->authRuleTree();


   		$authgroups=db('auth_group')->find(input('id'));
   		$this->assign(array(
            'authgroups'=>$authgroups,
            'AuthGroupRes'=>$AuthGroupRes
         ));
   		return view();
   }
}
