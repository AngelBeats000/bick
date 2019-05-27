<?php
namespace app\admin\controller;
use app\admin\model\Admin as AdminModel;
use app\admin\controller\Common;

class Admin extends Common
{
    // public function _initialize(){
    //     $admin=new AdminModel();
    // }

    public function lst()
    {
        //需要引用use think\Db
        //$res = DB::name('admin')->select();]
      //  $res=db('admin')->alias('a')->join('bk_auth_group_access c','a.id=c.uid')->join('bk_auth_group b','b.id=c.group_id or b.id=null')->field('a.id,a.name,b.title')->paginate(10);
        $auth=new Auth();
       
        $admin =new AdminModel();
        $res=$admin->getadmin();
        foreach ($res as $k => $v) {
            $_groupTitle=$auth->getGroups($v['id']);
            if($_groupTitle){
                $groupTitle=$_groupTitle[0]['title'];
                $v['groupTitle']=$groupTitle;
            }else{
                    $v['groupTitle']="暂未分配";
                }
            
        }
        $this->assign('res',$res);
        return view('list');
    }

    //添加
    public function add()
    {
        //如果收到post请求
    	if(request()->isPost()){
            //实例化app\admin\model\Admin as AdminModel
            $admin=new AdminModel();
            $data=input('post.');
            $validate = \think\Loader::validate('Admin');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }
            //post. 接收所有的数据
            if ($admin->addadmin($data)) {
                $this->success('添加管理员成功！','lst');
            }else{
                $this->error('添加失败！请重新操作！！');
            }
    		
    		return;//如果表单提交数据，直接返回，不再加载模板
    	}
        $authGroup=db('auth_group')->select();
        $this->assign('authGroup',$authGroup);
        return view();
    }


    //编辑
    public function edit($id)
    {
        $admins=db('admin')->field('id,name,password')->find($id);
        if (request()->isPost()) {
            $data=input('post.');
            $validate = \think\Loader::validate('Admin');
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $admin=new AdminModel();
            $savenum=$admin->saveadmin($data,$admins);
            if ($savenum=='2') {
                $this->error('用户名不能为空');
            }
            if ($savenum !==false) {
                $this->success('修改成功','lst');
            }else{
                $this->error('修改失败!!');
            }

            return;//如果表单提交数据，直接返回，不再加载模板
        }
        
        //如果用户消息不存在
        if (!$admins) {
            $this->error('用户不存在');
        }

         $authGroupRes=db('auth_group')->select();
         $groupAccess=db('auth_group_access')->where(array('uid'=>$id))->find();
        $this->assign(array(
            'admin'=>$admins,
            'authGroupRes'=>$authGroupRes,
            'groupAccess'=>$groupAccess['group_id'],
        ));
        return view();
    }


    //删除
    public function del($id){
        $admin=new AdminModel();
        $delnum=$admin->deladmin($id);
        if ($delnum=='1') {
            $this->success('删除成功','lst');
        }else{
            $this->error('删除失败');
        }
    }
}
