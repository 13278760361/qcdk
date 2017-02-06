<?php
namespace Home\Controller;
use Think\Controller; 
class PackController extends Controller {
    protected function _initialize(){
      /**/
    }
    public static function getNonceStr($length = 32) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        } 
        return $str;
    }
    // 签名校验
    public static function checkSign($sign_key, $data){
        ksort($data);
        $new_sign_key = sha1(http_build_query($data));
        return $sign_key == $new_sign_key;
    }
    public function ToUrlParams($data){
        $buff = "";
        foreach ($data as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        
        $buff = trim($buff, "&");
        return $buff;
    }
    public function MakeSign($data){
        //签名步骤一：按字典序排序参数
        ksort($data);
        $string = $this->ToUrlParams($data);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".C('WXKEY');;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }
    public function ToXml($value){
        $xml = "<xml>";
        foreach ($value as $key=>$val){
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }
    private static function postXmlCurl($xml, $url, $useCert = false, $second = 30){
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if($useCert == true){
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLCERT, './cert/apiclient_cert.pem');
            curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
            curl_setopt($ch,CURLOPT_SSLKEY, './cert/apiclient_key.pem');
        }
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else { 
            $error = curl_errno($ch);
            curl_close($ch);
        }
    }
    public function GetJsApiParameters($info){
        $data['appId'] = $info["appid"];
        $timeStamp = time();
        $data['timeStamp'] = (string)$timeStamp;
        $data['nonceStr'] = self::getNonceStr();
        $data['package'] = "prepay_id=" . $info['prepay_id'];
        $data['signType'] = "MD5";
        $data['paySign'] = $this->MakeSign($data);
        $parameters = json_encode($data);
        return $parameters;
    }
    //JSAPI支付 V3版本微信支付
    public function JsApi($Info){
        //②、统一下单
        //$tools = new \JsApiPay();
        //$openId = session('openid');
        $data['re_openid'] = $Info['openid'];

        $data['wxappid'] = C('WXAPPID');
        $data['mch_id'] = C('WXMCHID');
        $data['nonce_str'] = self::getNonceStr();
        $data['send_name'] = $Info['SendName']; // 商户名称
        $data['act_name'] = $Info['ActName']; // 活动名称
        $data['remark'] = $Info['Remark']; //备注
        //$data['body'] = $Info['Body'];
        $data['mch_billno'] = $Info['MchBillno'];
        $data['total_num'] = 1;
        $data['total_amount'] = $Info['TotalAmount'];
        $data['client_ip'] = $_SERVER['REMOTE_ADDR'];
        $data['wishing'] = $Info['Wishing']; // 祝福语
        $data['scene_id'] = 'PRODUCT_4'; // 场景ID
        //$data['notify_url'] = C('BACKURL');
        //$data['trade_type'] = 'JSAPI';
        $data['sign'] = $this->MakeSign($data);
        //dump($data);exit;
        $sendXML = $this->ToXml($data);
        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";   //微信红包
        $result = self::postXmlCurl($sendXML,$url,true);
        $order = json_decode(json_encode(simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $order;
        //dump($order);
        //$jsApiParameters = $this->GetJsApiParameters($order);
        //dump($jsApiParameters);
        //return $jsApiParameters;
        //return $order;
    }
    public function notify(){
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $handle =fopen('a.txt','a+'); 
        fwrite($handle,$xml);
        fclose($handle);
        if( $data['result_code'] == 'SUCCESS' ){
            $OrderSn = $data["out_trade_no"];
            $price = intval($data['cash_fee']);
            //$where['order_sn'] = $OrderSn;
            //$result = M("Order")->where($where)->find();
            $CL = A('Pay')->Service(array('id'=>$OrderSn,'pay_fee'=>$price));
            if($CL['status']){
                $xmlinfo['return_code'] = 'SUCCESS';
                $xmlinfo['return_msg'] = 'OK';
                $xmlinfo = array(
                    'return_code' => 'SUCCESS',
                    'return_msg' => 'OK'
                );
            } else {
                $xmlinfo = array(
                    'return_code' => 'FAIL',
                    'return_msg' => 'Pay Fail'
                );
            }
            // mch_billno 商户单号  re_openid 用户OPENID   total_amount 金额    send_listid 微信单号
            header('Content-Type: application/xml; charset=utf-8');
            $backXML =  '<xml><result_code><![CDATA['.$xmlinfo['return_code'].']]></result_code><return_msg><![CDATA['.$xmlinfo['return_msg'].']]></return_msg></xml>';
            $handle =fopen('a.txt','a+'); 
            fwrite($handle,$backXML);
            fclose($handle);
            echo $backXML;
        }
    }
}