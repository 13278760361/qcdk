<?php 
namespace Admin\Model;
use Think\Model;
class TextModel extends Model {

	  protected $_validate = array(     
	  array('keyword','require','关键词必填'),
	  array('keyword','','关键词已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一   
	  array('content','','回复必填！',0,'unique',1),  
	  );


    protected $_auto = array (

     
        array('create_time','time',Model:: MODEL_INSERT,'function'), // 对update_time字段在更新的时候写入当前时间戳

        array('update_time','time',Model:: MODEL_UPDATE,'function'), // 
    );

    
}