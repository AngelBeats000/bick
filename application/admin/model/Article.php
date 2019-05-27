<?php
namespace app\admin\model;
use think\Model;

class Article extends Model
{

    //查询数据
    public function catetree()
    {
        
       $cateres=db('cate')->select();   //select默认表为文件名cate
       return $this->sort($cateres,$pid=0,$level=0);
    }
    //排序
    public function sort($data,$pid=0,$level=0){
        static $arr=array(); //定义静态数组
        foreach ($data as $k => $v) {
            if($v['pid']==$pid){     //找到pid,即上级栏目为0的，该项为顶级栏目
                $v['level']=$level;    //顶级栏目level为0
                $arr[]=$v;             //赋给数组
                $this->sort($data,$v['id'],$level+1);   //递归调用，然后找出pid为顶级栏目id的项，level+1，正则
                
            }
        }
        return $arr;
    }


        //查找单页栏目
    public function cateone()
    {
        
       $cateres=db('cate')->field('id')->where('type',2)->select();   //select默认表为文件名cate
       static $arr=array();
       foreach ($cateres as $k => $v) {              //把查询到的结果由多维数组转换成一维数组
            $arr[]=$v['id'];
        }
        return $arr;
    }
    // //排序
    // public function articleone($data){
    //     static $_arr=array(); //定义静态数组
    //     static $arr=array();
    //     foreach ($data as $k => $v) {
    //         $a=db('article')->where('cateid',$v['id'])->select();          //查找单页栏目下的文章
    //         if ($a) {                                                       //如果单页栏目已经有文章了，把栏目id保存
    //             $_arr[]=$v; 
    //         }
    //     }
    //     foreach ($_arr as $k => $v) {              //把查询到的结果由多维数组转换成一维数组
    //         $arr[]=$v['id'];
    //     }
    //     return $arr;
    // }




   //事件，before_ 在...之前
   protected static function init()
    {
        Article::event('before_insert', function ($data) {
            if ($_FILES['thumb']['tmp_name']) {
                
                $file=request()->file('thumb');

                //$file = \think\Image::open(request()->file('thumb'));
                //$file->thumb(150, 150);
                // $image = Image::open($file);
                // $image->thumb(150, 150, Image::THUMB_CENTER);
                
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

                if ($info) {
                    $thumb='/bick/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $data['thumb']=$thumb;
                }
            }
        });


        Article::event('before_update', function ($data) {
            if ($_FILES['thumb']['tmp_name']) {
                $file=request()->file('thumb');
                //$file = \think\Image::open(request()->file('thumb'));
                //$file->thumb(150, 150);
                $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');

                if ($info) {
                    $thumb='/bick/' . 'public' . DS . 'uploads'.'/'.$info->getSaveName();
                    $data['thumb']=$thumb;
                }
                //删除图片
                $arts=Article::find($data->id);
                $path=$_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
                if (file_exists($path)) {
                    @unlink($path);
                }

            }
        });


        Article::event('before_delete', function ($data) {
                $arts=Article::find($data->id);
                $path=$_SERVER['DOCUMENT_ROOT'].$arts['thumb'];
                if (file_exists($path)) {
                    @unlink($path);
                }

            
        });



   }


}

