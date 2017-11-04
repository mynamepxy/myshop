<?php
namespace Admin\Model;
use Think\Model\RelationModel;

class GoodsModel extends RelationModel{
    //public $_link = array(
//        'cat' => array(
//             'mapping_type' => self::BELONGS_TO,
//             'foreign_key' => 'cat_id',
             //'mapping_name' => 'dept',
 //  定义更多的关联属性

      //),
   // );

    public $_auto = array(
        // array(完成字段1,完成规则,[完成条件,附加规则]),
        array('add_time','time',3,'function'),

        //array('add_time','time',1,'function'),
    );
    public $_validate = array(
        // array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
        array('goods_name','unique','名字已经存在','1','unique','3'),
        array('goods_name','require','不得为空','1','','3'),
        //array('shop_price','pr','shop_price错了','1','callback','3'),
    );
//    public function pr(){
//        return true;
//    }
//public function  inc(){
//    $this->where('id=5')->setInc('score',5);
//}
}
