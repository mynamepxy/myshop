<?php
namespace Home\Controller;
use Think\Controller;


class UserController extends Controller {

    public function login(){
        if(IS_POST){
            $username = I('post.username');
            $pwd = I('post.password');
            $code = I('post.yzm');
//            $verify = new \Think\Verify();
//                  if(!$verify->check($code)){
//                      $this->error('验证码错误');
//                  }

            $userModel = D('user');
            $userinfo = $userModel->where(array('username'=>$username))->find();
            if(!$userinfo){
                $this->error('用户名错误','',2);
            }
            //var_dump($userinfo['password']);echo "|";var_dump(md5($pwd.$userinfo['salt']));exit();
            if($userinfo['password']!=md5($pwd.$userinfo['salt'])){
                //$this->error('密码错误','',2);
            }else {
                cookie('userid',$userinfo['password']);
                cookie('username',$userinfo['username']);
                $coo_kie = jm($userinfo['username'].$userinfo['password'].C('COO_KIE'));
                cookie('key',$coo_kie);
                $this->success('','/',1);exit();
            }

        }


        $this->display();
    }

    public function logout(){
        cookie('username',null);
        cookie('userid',null);
        cookie('key',null);
        $this->success('恭喜你，进入恨的世界','/',3);
    }


    public function yzm(){
        $Verify = new \Think\Verify();
        $Verify->imageW = 250;
        $Verify->imageH = 62;
        $Verify->length = 4;
        $Verify->fontSize = 30;
        //var_dump($Verify->imageW);exit();
        //$Verify->useCurve = false;
        $Verify->useNoise = false;
        $Verify->entry();

    }
    public function msg(){
        $this->display();
    }
    public function reg(){
        if(IS_POST){
            $userModel = D('User');
            if(!$userModel->create()){
                echo $this->error($userModel->getError());
                exit;
            }
            $s = $this->yan();
            $userModel->password = md5($userModel->password.$s);
            $userModel->salt = $s;
            if($userModel->add()){
                $this->success('注册成功',U('login'));exit();
            }else{
                $this->error('注册失败');
            }
        }
        $this->display();
    }



    public function yan(){
        $str = 'asdfjlaskjf09[uuqtoi*&^*43hq5kja9430597(*&)]';
        return substr(str_shuffle($str),0,8);
    }
}
