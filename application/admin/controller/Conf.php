<?php
namespace app\admin\controller;
use app\admin\model\Conf as ConfModel;
use app\admin\controller\Common;

class Conf extends Common
{
   public function lst()
   {
        if (request()->isPost()) {
            $sorts=input('post.');
            $confs=new ConfModel();
            foreach ($sorts as $k => $v) {
                $confs->update(['id'=>$k,'sort'=>$v]);
            }
            $this->success('修改排序成功', 'lst');
            return;
        }
        $confres=ConfModel::order('sort desc')->paginate(10);
        $this->assign('conf',$confres);
        return view('list');
   }

   public function conf(){

    
    if (request()->isPost()) {
        $data=input('post.');
        $formall=array();
        $checkboxall=array();                 //表单提交时没有提到的数据
        foreach ($data as $k => $v) {
            $formall[]=$k;                   //把表单提交的数据的id提取出来
        }
        // dump($formall);die;
        $_confall=db('conf')->field('enname')->select();       //查询数据表里面所有项的enname(html里面的id)
        $confall=array();

        foreach ($_confall as $k => $v) {              //把查询到的结果由多维数组转换成一维数组
            $confall[]=$v['enname'];
        }
        // dump($confall);die;
        foreach ($confall as $ke => $v) {
            if (!in_array($v,$formall)) {
                $checkboxall[]=$v;
            }
        }
        //dump($checkboxall);die;
        if ($checkboxall) {
            foreach ($checkboxall as $k => $v) {
                ConfModel::where('enname',$v)->update(['value'=>'']);
            }
        }
        // dump($checkboxall);die;
        if ($data) {
            foreach ($data as $k => $v) {
                ConfModel::where('enname',$k)->update(['value'=>$v]);
            }
            $this->success('配置修改成功', 'conf');
        }
        
        
        // dump($data);die;
        return;
    }
    $confes=ConfModel::order('sort desc')->select();
    $this->assign('conf',$confes);
    return view();
   }

   public function add()
   {
    if (request()->isPost()) {
        $data=input('post.');
        if ($data['values']) {
            $data['values']=str_replace('，', ',', $data['values']);
        }

        $validate = \think\Loader::validate('Conf');    //数据验证
        if(!$validate->scene('one')->check($data)){
            $this->error($validate->getError());
        }

        $conf=new ConfModel();
        $a=$conf->save($data);
        if ($a) {
            $this->success('新增配置成功', 'lst');
        }else{
            $this->error('添加配置失败');
        }
        return;
    }
       return view();
   }

   public function edit()
   {
        if (request()->isPost()) {
            $data=input('post.');
            if ($data['values']) {
                $data['values']=str_replace('，', ',', $data['values']);
            }

            $validate = \think\Loader::validate('Conf');         //数据验证
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }

            $conf=new ConfModel();
            $save=$conf->save($data,['id'=>$data['id']]);
            if ($save!==false) {
                $this->success('修改配置成功', 'lst');
            }else{
                $this->error('修改失败');
            }
            return;
        }
        $confs=ConfModel::find(input('id'));
        $this->assign('confs',$confs);
        return view();
   }

   public function del(){
        $del=ConfModel::destroy(input('id'));
        if ($del) {
            $this->success('删除配置项成功', 'lst');
        }else{
            $this->error('删除失败');
        }
   }


}
