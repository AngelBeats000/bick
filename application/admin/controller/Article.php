<?php
namespace app\admin\controller;
use app\admin\controller\Common;
use app\admin\model\Cate;
use app\admin\model\Article as ArticleModel;

class Article extends Common
{
    public function lst(){
        $article=db('article')->alias('a')->join('bk_cate b','a.cateid=b.id')->field('a.id,a.title,a.thumb,a.author,b.catename,b.type')->paginate(10);
        //article表取别名a ,bk_cate表取别名b，关联条件，a.cateid=b.id,field()查询项
        // dump($article);die;
        $a=new ArticleModel();
        $b=$a->catetree();
        $this->assign(array(
            'article'=>$article,
            'b'=>$b
        ));
        return view('list');
    }

    public function add(){
       
        if (request()->isPost()) {
            $data=input('post.');
            $data['time']=time();

            if (input('rec')) {
                $data['rec']=1;
            }else{
                $data['rec']=0;
            }

            $validate = \think\Loader::validate('Article');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }
            $article=new ArticleModel();
            //必须采用save模型层添加，执行moedl里面的前置事件，图片先上传
            if ($article->save($data)) {
                $this->success('添加成功！','lst');
            }else{
                $this->error('添加失败！');
            }
            return;
        }

            //查询单页栏目
        $cateone=new ArticleModel();
        $b=$cateone->cateone();
        //dump($b);die;
        $cateres=new Cate();
        $cateres=$cateres->catetree();    //无限级分类
        $this->assign(array(
            'cateres'=>$cateres,    //所有栏目
            'cateone'=>$b,         //单页栏目的id      
        )); 
        return view();
    }

    public function edit(){
        $cateres=new Cate();
        if (request()->isPost()) {
            $data=input('post.');

            if (input('rec')) {
                $data['rec']=1;
            }else{
                $data['rec']=0;
            }

            $validate = \think\Loader::validate('Article');
            if(!$validate->scene('one')->check($data)){
                $this->error($validate->getError());
            }
            $article=new ArticleModel();
            $save=$article->save($data,['id'=>$data['id']]);
            if($save !==false){
                $this->success('修改成功！！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }

        $cateres=$cateres->catetree(); //无限分类
        $arts=db('article')->find(input('id'));
        $this->assign(array(
            'cateres'=>$cateres,
            'arts'=>$arts
        ));
        
        return view();
    }

    public function del(){
        if(ArticleModel::destroy(input('id'))){
            $this->success('删除文章成功！','lst');
        }else{
            $this->error('删除失败');
        }
    }

}
