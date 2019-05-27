<?php
namespace app\admin\controller;
use app\admin\model\Link as LinkModel;
use app\admin\controller\Common;

class Link extends Common
{
    

    public function lst()
    {
        $link =new LinkModel();
        if (request()->isPost()) {
            $sorts=input('post.');
            foreach ($sorts as $k => $v) {
                $link->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('更新排序成功','lst');
            return;
        }
        $linkres=LinkModel::order('sort desc')->paginate(10);
        $this->assign('linkres',$linkres);
        return view('list');

    }

    public function add(){
        if (request()->isPost()) {
            $data=input('post.');
            $validate = \think\Loader::validate('Link');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }
            $add=db('link')->insert($data);
            if ($add) {
                $this->success('新增友情链接成功', 'lst');
            }else{
                $this->error('新增链接失败');
            }
            return;
        }
        return view();
    }

    public function del(){
        $del=LinkModel::destroy(input('id'));
        if ($del) {
            $this->success('删除链接成功', 'lst');
        }else{
            $this->error('删除失败');
        }
    }

    public function edit()
    {
        if (request()->isPost()) {
            
            $data=input('post.');
            $validate = \think\Loader::validate('Link');
            if(!$validate->scene('two')->check($data)){
                $this->error($validate->getError());
            }
            $link=new LinkModel();
            $save=$link->save($data,['id'=>$data['id']]);
            if ($save !==false) {
                $this->success('修改链接成功', 'lst');
            }else{
                $this->error('修改链接失败');
            }
            return;
        }
        $links=LinkModel::find(input('id'));
        $this->assign('links',$links);
        return view();
    }

   



}
