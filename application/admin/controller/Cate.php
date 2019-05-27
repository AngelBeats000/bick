<?php
namespace app\admin\controller;
use app\admin\model\Cate as CateModel;
use app\admin\controller\Common;
use app\admin\model\Article;

class Cate extends Common
{
    protected $beforeActionList = [
        'delsoncate' => ['only'=>'del'],   //前置操作，执行del方法前先执行delsoncate方法，然后在执行del方法
        ];



    public function lst()
    {
        $admin =new CateModel();
        if (request()->isPost()) {
            $sorts=input('post.');
            foreach ($sorts as $k => $v) {
                $admin->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功','lst');
            return;
        }
        $cateres=$admin->catetree();
        $this->assign('cate',$cateres);
        return view('list');
    }



    public function add(){
        $cate= new CateModel();
        if (request()->isPost()) {
            $data=input('post.');
            $validate = \think\Loader::validate('Cate');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }
            $add=$cate->save($data);
            if ($add) {
                $this->success('添加成功','lst');
            }else{
                $this->error('添加失败');
            }
        }
        $cateres=$cate->catetree();
        $this->assign('cateres',$cateres);
        return view();
    }



    public function del()
    {
        $del=db('cate')->delete(input('id'));
        if($del){
            $this->success('删除成功！','lst');
        }else{
            $this->error('删除失败');
        }
    }

    //删除栏目时，要连着子栏目和栏目下的文章，文章的缩略图都删除
    public function delsoncate()
    {
        $cateid=input('id');      //获取要删除的当前栏目的id
        $cate=new CateModel();     
        $ids=$cate->getchilrenid($cateid);    //根据当前栏目id实例化CateModel,查找子栏目id
        $allid=$ids;        //把子栏目的id赋给allid
        $allid[]=$cateid;    //把当前栏目的id赋给allid数组 
        //$article=new Article();  //实例化文章，为删除栏目时，文章也删除做准备
        foreach ($allid as $k => $v) {
            Article::destroy(['cateid' => $v]); //删除文章,导入article的模型，通过destroy模型层删除，
        }
        db('cate')->delete($ids);   //删除子栏目
    }



    public function edit()
    {
        $cate=new CateModel();
        if (request()->isPost()) {
            $data=input('post.');
            $validate = \think\Loader::validate('Cate');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }
            $save=$cate->save($data,['id'=>$data['id']]);
            if ($save !==false) {
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;           //结束操作。使下面的代码不执行
        }
       
        $cates=$cate->find(input('id'));
        $cateres=$cate->catetree();
        $noids=$cate->getchilrenid(input('id'));
        $this->assign(array(
            'cateres'=>$cateres,
            'cates'=>$cates,
            'noids'=>$noids,
        ));

        //cateres为栏目排序结果，cates为要修改的项的内容,noids为根据id所查的其所有的子栏目
        return view();
    }



}
