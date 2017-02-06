<?php
/**
 * Created by PhpStorm.
 * User: Pacific
 * Date: 2016/9/20
 * Time: 10:27
 */
namespace Admin\Model;
use Think\Model;

class UsersModel extends Model{
    public function exportExcel($expTitle,$expCellName,$expTableData,$stime,$etime,$dname=''){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $fileName = $expTitle;//or $xlsTitle 文件名称可根据自己情况设定
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        $today = date('Y.m.d',time());
        vendor("PHPExcel.PHPExcel");

        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        foreach ($cellName as $key => $val) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($val)->setWidth(18);//单元格设置宽度
        }
        $styleThinBlackBorderOutline = array(
            'borders' => array (
                'outline' => array (
                    'style' => \PHPExcel_Style_Border::BORDER_THIN, //设置border样式 'color' => array ('argb' => 'FF000000'), //设置border颜色
                ),
            ),);
        if(empty($dname)){
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(50);//单元格设置宽度
            $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
            $objPHPExcel->getActiveSheet()->setCellValue('A1', '青才科技弹性部门考勤异常报表');
            $objPHPExcel->getActiveSheet(0)->mergeCells('A2:'.$cellName[$cellNum-1].'2');//合并单元格
            $objPHPExcel->getActiveSheet()->setCellValue('A2', "考勤日期:    ".$stime."——".$etime."                                                                                                                                                       打印日期：$today");

            $objPHPExcel->getActiveSheet()->getStyle('A:E')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //不平居中
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //不平居中
            $objPHPExcel->getActiveSheet()->getStyle('A:E')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);//字体大小
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);//字体加粗
            $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->getFont()->setBold(true);//字体加粗

            $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($styleThinBlackBorderOutline);
            $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleThinBlackBorderOutline);

            for($i=0;$i<$cellNum;$i++){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'3', $expCellName[$i][1]);
            }
            // Miscellaneous glyphs, UTF-8
            $f=4;
            for($i=0,$b=4,$d=5;$i<$dataNum;$i++,$b++,$d++){
                for($j=0;$j<$cellNum;$j++){
                    $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+4), $expTableData[$i][$expCellName[$j][0]]);
                }
                if($expTableData[$i]['sign_date'] !==$expTableData[$i+1]['sign_date']) {
                    $objPHPExcel->getActiveSheet(0)->mergeCells('A' . $f . ':A' . $b);//合并单元格
                    $f=$d;
                }
            }
            $g=$b-1;
            for($m=0;$m<=3;$m++){
                $x = $cellName[$m];
                $objPHPExcel->getActiveSheet()->getStyle($x.'1:'.$x.$g)->applyFromArray($styleThinBlackBorderOutline);
            }
            for($mm=1;$mm<=$g;$mm++){
                $objPHPExcel->getActiveSheet()->getStyle('A'.$mm.':'.'E'.$mm)->applyFromArray($styleThinBlackBorderOutline);
            }

        }else{

        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);//单元格设置宽度
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->getActiveSheet()->setCellValue('A1', '青才科技'.$dname.'考勤异常报表');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A2:'.$cellName[$cellNum-1].'2');//合并单元格
        $objPHPExcel->getActiveSheet()->setCellValue('A2', "考勤日期    ".$stime."——".$etime."                                                                                                                                                                                                                                                                                  打印日期：$today");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "");

        $objPHPExcel->getActiveSheet()->getStyle('A:H')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER); //水平居中
        $objPHPExcel->getActiveSheet()->getStyle('A:H')->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);//垂直居中

        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);//字体大小
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);//字体加粗
        $objPHPExcel->getActiveSheet()->getStyle('A3:H3')->getFont()->setBold(true);//字体加粗


        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'3', $expCellName[$i][1]);
        }
        // Miscellaneous glyphs, UTF-8
            $f=4;
            for($i=0,$b=4,$d=5;$i<$dataNum;$i++,$b++,$d++){
                for($j=0;$j<$cellNum;$j++){
                    $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+4), $expTableData[$i][$expCellName[$j][0]]);
                }
                if($expTableData[$i]['sign_date'] !==$expTableData[$i+1]['sign_date']) {
                    $objPHPExcel->getActiveSheet(0)->mergeCells('B' . $f . ':B' . $b);//合并单元格
                    $f=$d;
                }
            }
            $g=$b-1;
            $objPHPExcel->getActiveSheet(0)->mergeCells('A4:A' . $g);//合并单元格
            $objPHPExcel->getActiveSheet()->setCellValue('A4',$dname);
           for($m=0;$m<=6;$m++){
               $x = $cellName[$m];
               $objPHPExcel->getActiveSheet()->getStyle($x.'1:'.$x.$g)->applyFromArray($styleThinBlackBorderOutline);
           }
            for($mm=1;$mm<=$g;$mm++){
                $objPHPExcel->getActiveSheet()->getStyle('A'.$mm.':'.'H'.$mm)->applyFromArray($styleThinBlackBorderOutline);
            }
        }
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header("Content-Disposition:attachment;filename=$fileName.xls");//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
    /*
     * Excel导出
     * */
    public function expSign($stime,$etime,$xlsData){//导出Excel
        $xlsName  = "青才科技弹性部门考勤异常报表";
        $xlsCell  = array(
            array('sign_date','日期'),
            array('job_number','员工工号'),
            array('username','姓名'),
            array('leave_reason','异常原因'),
            array('confirm','确认'),
        );
        $this->exportExcel($xlsName,$xlsCell,$xlsData,$stime,$etime);
    }

    /*
 * Excel导出
 * */
    public function expDSign($stime,$etime,$xlsData,$dname){//导出Excel
        $xlsName  = "青才科技".$dname."考勤异常报表";
        $xlsCell  = array(
            array('','部门'),
            array('sign_date','日期'),
            array('job_number','工号'),
            array('username','姓名'),
            array('htime','上班时间'),
            array('xtime','下班时间'),
            array('leave_reason','异常类型'),
            array('confirm','确认'),
        );
        $this->exportExcel($xlsName,$xlsCell,$xlsData,$stime,$etime,$dname);
    }

}