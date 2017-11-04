<?php
namespace Admin\Controller;
//use function Common\Common\fenlei;
use Think\Controller;
//use function Common\Common\selectfenlei;

class CatController extends Controller {
    public function cateadd(){
        $catModel = D('Cat');
        if(IS_POST){


            if ($catModel->where(array('cat_id'=>I('post.parent_id')))->count("cat_id")){
                if(!$catModel->create(I('post.'))){
                    $this->Error($catModel->getError());exit();
                }
                if($catModel->add()){
                    //$this->redirect('admin/cat/cateadd','',3,'添加成功');exit;
                    $this->success('添加成功');exit();
                }
            }
        }

        $this->assign('select',selectfenlei(1));
        $this->display();
    }
    public function catelist(){
        $catModel = D('Cat');
        
        $this->assign('catlist',$catModel->gettree());
        $this->display();
    }
    public function cateedit(){

        $catModel = D('Cat');
        if(IS_POST){
            $cat_id = I('get.cat_id',null)?I('get.cat_id',null):I('post.cat_id',null);//var_dump(($catModel->where(array('cat_id'=>$cat_id))->select()));exit();
            if(!$catModel->where(array('cat_id'=>$cat_id))->select()){

                $this->redirect('catelist',null,3,'无此栏目');exit;
            }
            if($catModel->create(I('post.'))){

                if($catModel->save()){
                    $this->success('修改成功','catelist');exit();
                }else{
                    $this->error('修改失败','catelist');exit();
                }
            }else{
                //var_dump(I('post.'));exit();
                $this->error($catModel->getError(),'catelist');exit();
            }

        }


           if(IS_GET){
               $cat_id = I('get.cat_id',null);//var_dump(!($catModel->where(array('cat_id'=>$cat_id))->select()));exit();
               if($catModel->where(array('cat_id'=>$cat_id))->select()){
                   $this->assign('select',selectfenlei($cat_id,'edit'));
                   $this->assign('cat_id',$cat_id);
                   $this->display();
               }else{
                   $this->redirect('catelist',null,3,'无此栏目');exit;
               }

           }else{
               $this->redirect('catelist',null,3,'无此栏目');exit;
           }


    }

    public function catedel(){
        if(!empty(I('get.cat_id'))){

            $catModel = D('Cat');
            if($catModel->delete(I('get.cat_id'))){
                $this->redirect('catelist');exit;
            }else{
                $this->error('删除失败','catelist');exit;
            }
        }else{
            $this->redirect('catelist');exit;
        }
    }
}
