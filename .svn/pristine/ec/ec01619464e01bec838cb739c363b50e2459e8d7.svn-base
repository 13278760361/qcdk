<?php 
namespace Common\Controller;
use Think\Controller;
/**
* 底层控制器
*/
class BackController extends Controller
{
	
	function _initialize(){

        $this->assign('time',time()); //防止缓存时间戳
		//定义加载
		define('JS_PATH', '/Public/'.MODULE_NAME.'/js/');//js路径
		define('CS_PATH', '/Public/'.MODULE_NAME.'/css/');//css路径
		define('IM_PATH', '/Public/'.MODULE_NAME.'/images/');//图片路径 
		define('ORG_PATH', '/Public/'.MODULE_NAME.'/org/');//图片路径


	}
}

?>