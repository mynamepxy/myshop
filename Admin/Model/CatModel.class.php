<?php
namespace Admin\Model;
use Think\Model;

class CatModel extends Model{
    public function gettree($p = 0 ,$lv=0){
        $t = array();
        foreach($this->order('cat_id')->select() as $k=>$v){
            if($v['parent_id'] == $p){
                $v['lv'] = $lv;
                $t[] = $v;
                //检查
                $t = array_merge($t,$this->gettree($v['cat_id'],$lv+1));
            }
        }
        return $t;
    }
    //自动验证
    public $_validate = array(
        // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('cat_id','number','只能是数字',0,'','3'),
        //array('cat_name',array(1,100),'不能为空',0,'between'),
        array('cat_name','','名字已经存在',0,'unique',1),
        array('cat_name','require','名字不能为空',0,'',3),
        //array('intro','unique','已经存在',0,'unique',2),
        array('intro','lengthuft8','不能超过500个字符',0,'callback',3,500),

    );
    protected function lengthuft8($str,$max){
        preg_match_all('/./u',$str,$matches);
        $length = count($matches[0]);
        if($length>$max){
            return false;
        }else{
            return true;
        }
    }


}
