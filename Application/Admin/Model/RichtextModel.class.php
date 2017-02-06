<?php 
namespace Admin\Model;
use Think\Model;
class RichtextModel extends Model {

	  protected $_validate = array(     
	  array('keyword','require','关键词必填'),
	  array('keyword','','关键词已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一 
	  array('title','require','标题必填'),
	  array('title','','标题已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一 
	  array('content','','内容必填！',0,'unique',1),  
	  );


    protected $_auto = array (

     
        array('create_time','time',Model:: MODEL_INSERT,'function'), // 对update_time字段在更新的时候写入当前时间戳

        array('update_time','time',Model:: MODEL_UPDATE,'function'), // 

        // array('url','getUrl',3,'callback'), // 对name字段在新增和编辑的时候回调getName方法
    );


    // function getUrl(){
    // 	// return    ltrim(C('site_url'),"/") .U('Home/Weixin/richtext',array('id'=>$this->getLastInsID());
    // 	// return $this->getLastInsID();
    // 	return U('Home/Weixin/index',array('id'=>$this->getLastInsID()));
    // }

    
}