<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/1
 * Time: 15:00
 * Author:zhj
 */
namespace Admin\Controller;

use Common\Controller\ABaseController;

class ExcelSalaryController extends ABaseController{
    public function index()
    {
        $this->display();
    }
    //导入工资条
    public function impsalary()
    {
       if(!empty($_FILES)){
           $upload = new \Think\Upload();// 实例化上传类
           $filepath=C('UPLOAD_PATH').'Excel/';
           $upload->exts = array('xlsx','xls');// 设置附件上传类型
           $upload->rootPath  =  $filepath; // 设置附件上传根目录
           $upload->saveName  =     'time';
           $upload->autoSub   =     false;
           if (!$info=$upload->upload()) {
               $this->error($upload->getError());
           }
           foreach ($info as $key => $value) {
               unset($info);
               $info[0]=$value;
               $info[0]['savepath']=$filepath;
           }
           vendor("PHPExcel.PHPExcel");
           $file_name=$info[0]['savepath'].$info[0]['savename'];
           $objReader = \PHPExcel_IOFactory::createReader('Excel5');
           $objPHPExcel = $objReader->load($file_name,$encode='utf-8');
           $sheet = $objPHPExcel->getSheet(0);
           $highestRow = $sheet->getHighestRow(); // 取得总行数
           $highestColumn = $sheet->getHighestColumn(); // 取得总列数
           $j=0;
          $sDate = date('Ym01', strtotime(date("Y-m-d")));
          $eDate = date('Ymd', strtotime("$sDate +1 month -1 day")) ;
//           echo date('Ymd',1472580380);
          $data['time'] = time();
           if(M('Wages')->where("FROM_UNIXTIME( time, '%Y%m%d' ) between $sDate and $eDate ")->find()){
               unlink($file_name);
               die('本月的工资信息已经导入,请下个月再操作!');
           }else {
           for($i=4;$i<=$highestRow;$i++)
           {
               $jid= $objPHPExcel->getActiveSheet()->getCell("D".$i)->getValue();
               $unm= $objPHPExcel->getActiveSheet()->getCell("E".$i)->getValue();
               $where['job_number'] = $jid;
               $where['username'] = $unm;
               if( $ii = M('Users')->where($where)->getField('id')){
                  $data['user_id'] = $ii;
               }
               $data['base_pay'] = $objPHPExcel->getActiveSheet()->getCell("F".$i)->getValue();
               $data['post_all'] = $objPHPExcel->getActiveSheet()->getCell("G".$i)->getValue();
               $data['meal_all'] = $objPHPExcel->getActiveSheet()->getCell("H".$i)->getValue();
               $data['com_sub'] = $objPHPExcel->getActiveSheet()->getCell("I".$i)->getValue();
               $data['mer_pay'] = $objPHPExcel->getActiveSheet()->getCell("J".$i)->getValue();
               $data['act_att'] = $objPHPExcel->getActiveSheet()->getCell("K".$i)->getValue();
               $data['end_ins'] = $objPHPExcel->getActiveSheet()->getCell("M".$i)->getValue();
               $data['une_ins'] = $objPHPExcel->getActiveSheet()->getCell("N".$i)->getValue();
               $data['med_ins'] = $objPHPExcel->getActiveSheet()->getCell("O".$i)->getValue();
               $data['ill_ins'] = $objPHPExcel->getActiveSheet()->getCell("P".$i)->getValue();
               $data['acc_fund'] = $objPHPExcel->getActiveSheet()->getCell("Q".$i)->getValue();
               $data['hou_fund'] = $objPHPExcel->getActiveSheet()->getCell("R".$i)->getCalculatedValue();
               $data['indiv'] = $objPHPExcel->getActiveSheet()->getCell("S".$i)->getValue();
               $data['wages'] = $objPHPExcel->getActiveSheet()->getCell("U".$i)->getCalculatedValue();
                   M('Wages')->add($data);
                   $j++;
               }
           }
           unlink($file_name);
           // User_log('批量导入联系人，数量：'.$j);
           $this->success('导入成功！本次导入数量：'.$j.'<br/>'.$noT,'',100);
       }
    }
    //删除本月工资信息
    public function clear()
    {
        $sDate = date('Ym01', strtotime(date("Y-m-d")));
        $eDate = date('Ymd', strtotime("$sDate +1 month -1 day"));
        if(!(M('Wages')->where("FROM_UNIXTIME( time, '%Y%m%d' ) between $sDate and $eDate ")->find())){
            $this->error('你还没导入这个月的工资信息');
        }else{
        if (M('Wages')->where("FROM_UNIXTIME( time, '%Y%m%d' ) between $sDate and $eDate ")->delete()) {
            $this->success('本月工资信息已清空');
        }
        }
    }
}