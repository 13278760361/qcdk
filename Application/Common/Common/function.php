<?php

/**
 * 验证码检查
 * @param  intval  $page
 * @return url
 */

function checkVerify($code, $id = ''){ 
$verify = new \Think\Verify();    
return $verify->check($code, $id);
}

/**
 * 混合加密密码
 * @param string    $data   待加密字符串
 * @return string 返回加密后的字符串
 */
function encrypt($data) {
    return md5(C('AUTH_CODE').$data);
    //return md5(C("AUTH_CODE") . md5($data));
}

// /**
//  * 日志记录(暂时不用)
//  * @param string    $data   待加密字符串
//  * @return string 返回加密后的字符串
//  */
// function writeLog($uid,$username,$msg,$status){
// 	// dump($msg);exit();
// 	if (empty($uid)) {
// 		$uid = session('admin_id');
// 	}
// 	if (empty($username)) {
// 		$username = session('admin_username');
// 	}
// 	$db = M('Admin_log');
// 	$data['action_id'] = $uid;
// 	$data['action_group'] = '管理员';
// 	$data['action_user'] = $username;
// 	$data['action_ip'] = get_client_ip();
// 	$data['time'] =time();
// 	$data['remark'] = $msg;
// 	$data['action_status'] = $status;
// 	$db->add($data);
// }

/**
 * 后台操作日志记录
 * @param string    $data   待加密字符串
 * @return string 返回加密后的字符串
 */
function aWriteLog($msg,$status){
	$db=D('Admin_log');
	$db->write_log($msg,$status);	
}


function daddslashes($string, $force = 1) {
     if(is_array($string)) {
          $keys = array_keys($string);
          foreach($keys as $key) {
                $val = $string[$key];
                unset($string[$key]);
                $string[addslashes($key)] = daddslashes($val, $force);
          }
     } else {
          $string = addslashes($string);
     }
     return $string;
}


/**
 * 获取系统信息
 */
function getSystem(){
    $System =array(
         'OS'=>php_uname('s'),
         'WEB'=>$_SERVER['SERVER_SOFTWARE'],
         'SQL'=>'Mysql()',
         'FRAME'=>'ThinkPhp',
         'SERVER_NAME'=>$_SERVER['SERVER_NAME'],
         'PHP_VERSION'=>'php(' . PHP_VERSION .')',
         'LOCAL_TIME'=>date('Y-m-d H:i:s'),
    );
    return $System;
  }
  /**
 * 删除目录或者文件
 * @param  string  $path
 * @param  boolean $is_del_dir
 * @return fixed
 */
function del_files($path, $is_del_dir = FALSE) {
    $handle = opendir($path);
    if ($handle) {
        // $path为目录路径
        while (false !== ($item = readdir($handle))) {
            // 除去..目录和.目录
            if ($item != '.' && $item != '..') {
                if (is_dir("$path/$item")) {
                    // 递归删除目录
                    del_files("$path/$item", $is_del_dir);
                } else {
                    // 删除文件
                    unlink("$path/$item");
                }
            }
        }
        closedir($handle);
        if ($is_del_dir) {
            // 删除目录
            return rmdir($path);
        }
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return false;
        }
    }
}
/**
* @param string $dir
* @return array
*/
function my_scandir($dir){
$files = array();
 if ( $handle = opendir($dir) ) {
  while ( ($file = readdir($handle)) !== false ){
   if ( $file != ".." && $file != "." ){
    if ( is_dir($dir . "/" . $file) ){
     $files[$file] = my_scandir($dir . "/" . $file);
    }else {
     $files[] = $file;
    }
   }
  }
  closedir($handle);
  return $files;
 }
}

/**
 * 格式化的文件大小
 * @param  int $bytes
 * @return string
 */
function bytes_format($bytes) {
    // 单位
    $unit = array(' B', ' KB', ' MB',
                  ' GB', ' TB', ' PB',
                  ' EB', ' ZB', ' YB');

    // bytes的对数
    $log_bytes = floor(log($bytes, 1024));
    return round($bytes / pow(1024, $log_bytes), 2) . $unit[$log_bytes];
}

/**
 * 短信发送
 * @param  int $bytes
 *http://smsbao.com/
 *$rst['30'] = '密码错误';
 *$rst['40'] = '账号不存在';
 *$rst['41'] = '余额不足';
 *$rst['42'] = '帐号过期';
 *$rst['43'] = 'IP地址限制';
 *$rst['50'] = '内容含有敏感词';
 *$rst['51'] = '手机号码不正确';
 * @return string
 */
function sendSms($Mobiles,$Content){

    $sms = new \Org\Util\SmsBao(C('sms_account'),C('sms_password'));//在短信宝注册的账户名和密码
    $result = $sms->sendSms($Mobiles,"【".C('sms_tag')."】 ".$Content);
    return $result; 
}


/**
 * 查询短信剩余条数
 * @param  int $bytes
 * @return string
 */
function smsNum(){
   $sms = new \Org\Util\SmsBao(C('sms_account'),C('sms_password'));//在短信宝注册的账户名和密码
   $balance =(int)$sms->getBalance();//返回值即为剩余条数
   return $balance;
}

/**
 * 返回数组的维度
 * @param  [type] $arr [description]
 * @return [type]      [description]
 */
function arrayLevel($arr){
    $al = array(0);
    function aL($arr,&$al,$level=0){
        if(is_array($arr)){
            $level++;
            $al[] = $level;
            foreach($arr as $v){
                aL($v,$al,$level);
            }
        }
    }
    aL($arr,$al);
    return max($al);
}

//获取当月所有时间日期格式 2016-9-1 
function getDateArr($date){
    if ( empty($date) ) {
       $sql ="SELECT
(
CURDATE() - INTERVAL (DAY ( CURDATE() )) DAY
) + INTERVAL s DAY AS dt
FROM
(
SELECT
1 AS s
UNION ALL
SELECT
2
UNION ALL
SELECT
3
UNION ALL
SELECT
4
UNION ALL
SELECT
5
UNION ALL
SELECT
6
UNION ALL
SELECT
7
UNION ALL
SELECT
8
UNION ALL
SELECT
9
UNION ALL
SELECT
10
UNION ALL
SELECT
11
UNION ALL
SELECT
12
UNION ALL
SELECT
13
UNION ALL
SELECT
14
UNION ALL
SELECT
15
UNION ALL
SELECT
16
UNION ALL
SELECT
17
UNION ALL
SELECT
18
UNION ALL
SELECT
19
UNION ALL
SELECT
20
UNION ALL
SELECT
21
UNION ALL
SELECT
22
UNION ALL
SELECT
23
UNION ALL
SELECT
24
UNION ALL
SELECT
25
UNION ALL
SELECT
26
UNION ALL
SELECT
27
UNION ALL
SELECT
28
UNION ALL
SELECT
29
UNION ALL
SELECT
30
UNION ALL
SELECT
31
) m
WHERE
s <= DAY (LAST_DAY(CURDATE()))";
    }else{
            $sql ="SELECT
(
'{$date}' - INTERVAL (DAY ( '{$date}' )) DAY
) + INTERVAL s DAY AS dt
FROM
(
SELECT
1 AS s
UNION ALL
SELECT
2
UNION ALL
SELECT
3
UNION ALL
SELECT
4
UNION ALL
SELECT
5
UNION ALL
SELECT
6
UNION ALL
SELECT
7
UNION ALL
SELECT
8
UNION ALL
SELECT
9
UNION ALL
SELECT
10
UNION ALL
SELECT
11
UNION ALL
SELECT
12
UNION ALL
SELECT
13
UNION ALL
SELECT
14
UNION ALL
SELECT
15
UNION ALL
SELECT
16
UNION ALL
SELECT
17
UNION ALL
SELECT
18
UNION ALL
SELECT
19
UNION ALL
SELECT
20
UNION ALL
SELECT
21
UNION ALL
SELECT
22
UNION ALL
SELECT
23
UNION ALL
SELECT
24
UNION ALL
SELECT
25
UNION ALL
SELECT
26
UNION ALL
SELECT
27
UNION ALL
SELECT
28
UNION ALL
SELECT
29
UNION ALL
SELECT
30
UNION ALL
SELECT
31
) m
WHERE
s <= DAY (LAST_DAY( '{$date}' ))";
    }
   

$dateArr = M()->query($sql);
return $dateArr;
}


// function get_access_token(){

//     $wechat = new \Com\WechatAuth(C('appid'),C('appsecret'),C('token'));
//     $access_token = $wechat->getAccessToken();
//     return $access_token;
// }

// 处理带Emoji的数据，type=0表示写入数据库前的emoji转为HTML，为1时表示HTML转为emoji码
function deal_emoji($msg, $type = 1) {
    if ($type == 0) {
        $msg = json_encode ( $msg );
    } else {
        $txt = json_decode ( $msg );
        if ($txt !== null) {
            $msg = $txt;
        }
    }
    return $msg;
}


//订单计算
    function orderSn(){ 
        return (intval(date('Y'))-2015).strtoupper(dechex(date('m'))).date('d').substr(time(),-5).substr(microtime(),2,5).sprintf('%d',rand(0,99));
    }
