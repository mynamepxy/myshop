<?php
namespace Home\Controller;
use Think\Controller;
//use function Common\Common\che;
class IndexController extends Controller {
    public function index(){
        // $addTool = new \Home\Tool\AddTool();
        // var_dump($addTool->user());
        // exit;

//        $catModel = D('Admin/Cat');
//
//        $his = array_reverse(session('his'),true);
//
//        $this->assign('his',$his);
//        $this->assign('cattree',$catModel->gettree());
//
//        //热销
//        $goodsModel =  D('Admin/goods');
//        $hot = $goodsModel->field('goods_id,goods_name,shop_price,goods_img,market_price')->where('is_hot=1')->order('goods_id desc')->limit('0,4')->select();
//        $this->assign('hot',$hot);
          $catModel = D('Admin/Cat');
          $cats = $catModel->gettree();
          $goodsModel = D('Admin/Goods');
          $hot = $goodsModel->where(array('is_hot'=>1))->order('goods_id desc')->limit(0,4)->select();
          $best = $goodsModel->where(array('is_best'=>1))->order('goods_id desc')->limit(0,4)->select();
          $new = $goodsModel->where(array('is_new'=>1))->order('goods_id desc')->limit(0,4)->select();
          $this->assign('cats',$cats);
          $this->assign('best',$best);
          $this->assign('new',$new);
          $this->assign('hot',$hot);
          $this->display();
    }
}
