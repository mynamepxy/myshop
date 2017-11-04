<?php
namespace Admin\Controller;
use Think\Controller;
//use function Common\Common\r1;
//use function Common\Common\selectfenlei;
//use function Common\Common\fenlei;
class GoodsController extends Controller {
    public $gm;
    public function __construct(){
        parent::__construct();
        $this->gm = D('goods');
    }
    //商品添加
    public function goodsadd(){
        if(IS_POST){

            if(!$this->gm->create($_POST)){
                $this->error($this->gm->getError());
                exit;
            }

            $upload = new \Think\Upload();//  实例化上传类
            $upload->maxSize = 3145728 ;//  设置附件上传大小
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');//  设置附件上传类
            $upload->savePath = 'uploads/goods/'; //  设置附件上传目录
            $info = $upload->upload();//  上传文件

         if(!$info&&$_FILES['goods_img']['name']!='') {//  上传错误提示错误信息

                  $this->error($upload->getError());

         }else{
             if($this->gm->goods_sn==''){
                 $this->gm->goods_sn = r1()[0];
             }

             $goods['goods_img'] = ltrim($info['goods_img']['savepath'],'.').$info['goods_img']['savename'];
             $this->gm->goods_img = $goods['goods_img'];

             if($this->gm->add()){

                 $this->success(' 上传成功！ ');exit();

             }else{

                 $this->error('添加失败');
             }

         }


        }
        $catModel = M('Cat');
        $cat = $catModel->select();
        $this->assign('select',selectfenlei(1,'add','cat_id'));
        $this->assign('cat',$cat);
        $this->display();
    }

    //商品列表
    public function goodslist(){

        $cat_id = I('get.cat_id')?I('get.cat_id'):0;
        $catModel = M('Cat');



         $this->assign('select',selectfenlei($cat_id,'goodslist','cat_id'));

        if($cat_id==0){

            $count = $this->gm->count();// 查询满足要求的总记录数

        }else{
            $pid = $catModel->where(array('cat_id'=>$cat_id))->find()['parent_id'];
            $count = 0;
            $count = $this->gm->where(array('cat_id'=>$cat_id))->count();// 查询满足要求的总记录数


            $list = fenlei($cat_id);

            foreach ($list as $k=>$v){
             $count+=$this->gm->where(array('cat_id'=>$v['cat_id']))->count();

            }

        }

        $page=new \Org\Mypage\Page($count,3);
        if($cat_id==0) {
            $list = $this->gm->limit($page->firstRow . ',' . $page->listRows)->select();
        }else{
            //$pid = $catModel->where(array('cat_id'=>$cat_id))->find()['parent_id'];
            $list1 = fenlei($cat_id);
            $cats_id=$cat_id.',';
            foreach ($list1 as $k=>$v){
            $cats_id.=$v['cat_id'].',';


            }//'cat_id in (3,5,7)'
            $cats_id = rtrim($cats_id,',');
           // var_dump($cats_id);exit();
           // $map['cat_id'] =
            $list = $this->gm->where(array('cat_id'=>array('in',$cats_id)))->limit($page->firstRow . ',' . $page->listRows)->select();
            //var_dump($list);
        }
        $show=$page->show();
        $this->assign('list',$list);
        $this->assign('page',$show);// 赋值分页输出
         $this->display();
    }

    public function goodsdel(){
        if(!empty(I('get.goods_id'))){

            if(is_numeric(I('get.goods_id'))) {
                if ($this->gm->delete(I('get.goods_id'))) {
                    $this->success('删除成功', U('Admin/goods/goodslist'));
                } else {
                    $this->error('删除失败');
                }
            }else{
                $this->error('只能是数字');
            }

        }else{
            $this->error('输入商品号',U('Admin/goods/goodslist'));
        }
    }
    public function test()
    {
        $Verify = new \Think\Verify();
        $Verify->entry();
        }
        public function test1(){
          echo r()[0];
        }

    public function goodsedit(){
            if(I('get.goods_id')){
                $goods_id = I('get.goods_id');
                $cat_id = $this->gm->where(array('goods_id'=>$goods_id))->find()['cat_id'];

                $list = $this->gm->where(array('goods_id'=>$goods_id))->find();
                $this->assign('select',selectfenlei($cat_id,'goodsedit','cat_id'));
                $this->assign('list',$list);
                //var_dump($list);exit();
                $this->display();
            } else if(IS_POST){

                if($this->gm->create(I('post.'))){

                    if($_FILES['goods_img']['name'] != '') {
                        $upload = new \Think\Upload();//  实例化上传类
                        $upload->maxSize = 3145728;//  设置附件上传大小
                        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');//  设置附件上传类
                        $upload->savePath = 'uploads/goods/'; //  设置附件上传目录
                        $info = $upload->upload();//  上传文件

                        if (!$info && $_FILES['goods_img']['name'] != '') {//  上传错误提示错误信息

                            $this->error($upload->getError());

                        } else {

                            $goods['goods_img'] = ltrim($info['goods_img']['savepath'],'.').$info['goods_img']['savename'];
                            $this->gm->goods_img = $goods['goods_img'];//var_dump($goods['goods_img']);
                        }
                    }

                    if ($this->gm->goods_sn == '') {
                        $this->gm->goods_sn = r()[0];
                    }

                    if ($this->gm->save()) {
                        $this->success('修改成功',U('goodslist'));
                        } else {
                            $this->error('修改失败');
                        }

                }else{
                    $this->error('输入错误');
                }

            }else{
                $this->error('输入商品号',U('Admin/goods/goodslist'));
            }

    }





        //cat筛选
        public function cat(){
            $cat_id = I('get.cat_id');
            if($cat_id=='all'){

                $data = $this->gm->select();

            }else{

                $data = $this->gm->where(array('cat_id'=>$cat_id))->select();
            }

//            $count = $this->gm->count();// 查询满足要求的总记录数
//
//            $page=new \Org\Mypage\Page($count,2);
//            $list=$this->gm->limit($page->firstRow.','.$page->listRows)->select();
//            $show=$page->show();

            $data = json_encode($data);
            echo $data;
            //echo $show;
            exit();
        }
        public function myinfolist(){
//            $goods = M('Goods'); // 实例化User对象
//            $count = $goods->count();// 查询满足要求的总记录数
//
//            $page=new \Org\Mypage\Page($count,2);
//            $list=$this->gm->limit($page->firstRow.','.$page->listRows)->select();
//            $show=$page->show();
//            echo $show;
//            var_dump($list);
            //实例化数据模型
//            $info=M('Goods');
//            //统计要查询数据的数量
//            $count=$info->count();
//            //实例化分页类，传入三个参数，分别是数据总数、每页显示的数据条数、要调用的jQuery ajax方法名
//            $p=new \Org\Mypage\AjaxPage($count,2,'index');
//            //产生分页信息
//            $page=$p->show();
//            //要查询的数据,limit表示每页查询的数量，这里为10条
//            $data = $info->limit($p->firstRow.','.$p->listRows)->select();
//            //assign方法往模板赋值
//            $this->assign('list',$data);
//            $this->assign('page',$page);
//            //ajax返回信息，就是要替换的模板
//            $res["content"] = $this->fetch('Goods/myinfolist');
//            $this->ajaxReturn($res);
        }
        public function t(){
            $this->display();
        }

}
