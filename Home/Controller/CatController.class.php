<?php
namespace Home\Controller;
use Think\Controller;
//use function Common\Common\selectfenlei;
//use function Common\Common\fenlei;
//use function Common\Common\list1;
//use function Common\Common\mianbao;
class CatController extends Controller {
    public function cat(){
        $goodsModel = D('Admin/goods');

//        $count = $goodsModel->field('goods_id,goods_name,shop_price,goods_img,market_price')->where('cat_id='.I('cat_id'))->count();
//        $Page       = new \Think\Page($count,10);
//        $show       = $Page->show();
//        $goodsList = $goodsModel->field('goods_id,goods_name,shop_price,goods_img,market_price')->where('cat_id='.I('cat_id'))->limit($Page->firstRow.','.$Page->listRows)->select();
//        $this->assign('count',$count);
//        $this->assign('goodslist',$goodsList);
//        $this->assign('page',$show);
//        $this->display();
        $cat_id = I('get.cat_id')?I('get.cat_id'):0;
        $catModel = D('Admin/Cat');

        $pid = $catModel->where(array('cat_id'=>$cat_id))->find()['parent_id'];

            $count = 0;
            $count = $goodsModel->where(array('cat_id'=>$cat_id))->count();// 查询满足要求的总记录数


            $list = fenlei($cat_id);

            foreach ($list as $k=>$v){
                $count+=$goodsModel->where(array('cat_id'=>$v['cat_id']))->count();

            }



        $page=new \Org\Mypage\Page($count,6);

            $list1 = fenlei($cat_id);
            $cats_id=$cat_id.',';
            foreach ($list1 as $k=>$v){
                $cats_id.=$v['cat_id'].',';


            }
        $cats_id = rtrim($cats_id,',');
        $goodsList = $goodsModel->where(array('cat_id'=>array('in',$cats_id)))->limit($page->firstRow . ',' . $page->listRows)->select();
        $cat = $catModel->gettree();

        $show=$page->show();
        $mbx = '<a href="'.U('Home/Index/index').'">首页-></a>'.list1($cat_id);
        $this->assign('goodslist',$goodsList);
        $this->assign('mbx',$mbx);
        $this->assign('cat',$cat);//分类
        $this->assign('page',$show);// 赋值分页输出
        //var_dump($list);exit();
        $this->display();
    }
}
