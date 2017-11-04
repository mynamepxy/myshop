<?php
//namespace Common\Common;
use Think\Model;

function jm($a){
    return md5($a);
}

function che(){

    return jm(cookie('username').cookie('userid').C('COO_KIE')) === cookie('key');
}

function fenlei($pid=0,&$list=[],$nb=0){
    $nb+=2;
    $cat = M('Cat');
    //$sql = "select * from cat where parent_id = $pid";
    $data = $cat->where(array('parent_id'=>$pid))->order('cat_id')->select();

    foreach ($data as $k=>$v){
        $v['cat_name']=str_repeat('&nbsp;&nbsp;',$nb).'-|'.$v['cat_name'].'<br/>';
        $list[] = $v;
        fenlei($v['cat_id'],$list,$nb);
    }

    return $list;
}
function selectfenlei($id=1,$action='add',$name='parent_id'){

    $cat = M('Cat');
    $data = fenlei();
    $pid = $cat->field('parent_id')->where(array('cat_id'=>$id))->find();
    $str ='';
    $str.="<select name='$name' onchange='c1(this)'>";
    if($action=='add'){

        foreach ($data as $k=>$v){


            $str.='<option value="'.$v['cat_id'].'">'.$v['cat_name'].'</option>';


        }
    }
    if($action=='goodslist'){
        $str .= '<option value="all"> 全部 </option>';
        foreach ($data as $k=>$v){

            if($v['cat_id']==$id){
                $str.='<option selected="selected" value="'.$v['cat_id'].'">'.$v['cat_name'].'</option>';

            }else{

                $str.='<option value="'.$v['cat_id'].'">'.$v['cat_name'].'</option>';
            }


        }
    }
    if($action=='edit'){
        if($pid['parent_id']!=0){
            // var_dump($pid);

            foreach ($data as $k=>$v){
                if($pid['parent_id']==$v['cat_id']){
                    $str.='<option selected="selected" value="'.$v['cat_id'].'">'.$v['cat_name'].'</option>';
                }else{
                    $str.='<option value="'.$v['cat_id'].'">'.$v['cat_name'].'</option>';
                }

            }
        }
    }
    if($action=='goodsedit') {

        foreach ($data as $k => $v) {
            if($v['cat_id']==$id){
                $str.='<option selected="selected" value="'.$v['cat_id'].'">'.$v['cat_name'].'</option>';

            }
            $str .= '<option value="' . $v['cat_id'] . '">' . $v['cat_name'] . '</option>';
        }
    }
    $str.='</select>';
    return $str;
}
function mianbao($id,&$list = []){
    //static $list = [];
    $cat = M('Cat');
    $data = $cat->where(array('cat_id'=>$id))->select();
    // var_dump($data);
    foreach ($data as $k=>$v){
        $v['cat_name'] = $v['cat_name'].'->';
        $list[] = $v;
        //var_dump($list);
        mianbao($v['parent_id'],$list);
    }
    return $list;
}
function list1($id){
    $data = mianbao($id);
    krsort($data);
    //var_dump($data);
    $str='';
    foreach ($data as $k=>$v){
        $str.='<a href="'.U('Home/Cat/cat',array('cat_id'=>$v['cat_id'])).'">'.$v['cat_name'].'</a>';
    }
    return $str;

}

function quan(){
    $list = [];
    $likecat = M('Likecact');
    $sql = "select id,path,catename,concat(path,',',id) as fullpath from likecat ORDER by fullpath";
    $data = $likecat->query($sql);
    foreach ($data as $k=>$v){

        $v['catename'] = str_repeat('&nbsp;',substr_count(ltrim($v['fullpath'],','),',')*3).'-|'.$v['catename'];
        $list[] = $v;
    }
    return $list;
}
function quan1($id=1)
{
    $data = quan();
    $str = '';
    $str .= '<select>';
    foreach ($data as $k => $v) {
        if($id==$v['id']){
            $str .= '<option selected="selected">' . $v['catename'] . '</option>';
        }else{

            $str .= '<option>' . $v['catename'] . '</option>';
        }
    }
    $str .= '</select>';
    echo $str;
}
function quanlist($id){
    $likecat = M('Likecat');
    $data = $likecat->field('path')->where(array('id'=>$id))->find();
    var_dump($data);

}

function r1(&$list=[]){
    $goods = M('Goods');
    $ra = rand(1,1000000000);
    $a = $goods->field('goods_sn')->select();
    for ($i = 0 ;$i<count($a);$i++){

        if($ra==$a[$i]['goods_sn']){
            //echo $ra.'='.$a[$i]['goods_sn'].'<br>';
            r($list);
            break;
        }
    }
    $list[] = $ra;
    return $list;
}
