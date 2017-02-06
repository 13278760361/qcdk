<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/8
 * Time: 9:31
 */
namespace Admin\Controller;
use Common\Controller\ABaseController;

class WorkController extends ABaseController{
    public function _initialize(){
        parent::_initialize();
        $this->db = M('Users'); //当前模块数据库
        $this->assign('departs', M('Depart')->where(array('status'=>1))->getField('id,depart_name'));
    }
    public function index()
    {
        //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $departs   = I('get.departs')?I('get.departs'):'';
        $sex   = I('get.sex')?I('get.sex'):'';
        $start_time = I('get.start_date')?:'';
        $end_time = I('get.end_date')?:'';
        $jyids = !empty($jyids)?$jyids:0;
        $where = "s.user_id=u.id AND u.depart_id=d.id AND s.sign_type=1 AND u.depart_id not in ($jyids)";
        if($keyword){
            $where.=" AND ( u.job_number like '%{$keyword}%' OR u.username like '%{$keyword}%') ";
        }
        if($departs){
            $where.="AND d.id=$departs";
        }
        if($sex){
            if($sex==3){
                $where.=" AND u.sex=0";
            }else{
                $where.=" AND u.sex={$sex}";
            }
        }
        if($start_time && $end_time){
            $stim= strtotime($start_time);
            $etim= strtotime($end_time);
            $where.=" AND (s.sign_time between $stim and $etim)";
        }
        if($start_time){
            $stim= strtotime($start_time);
            $where.=" AND (s.sign_time >=$stim)";
        }
        if($end_time){
            $etim= strtotime($end_time);
            $where.=" AND (s.sign_time<=$etim)";
        }
        $count=M('Sign_history')->field('u.username,u.sex,u.job_number,d.depart_name,s.sign_time,s.sign_date,s.sign_type')
            ->table(array('qcdk_sign_history'=>'s','qcdk_users'=>'u','qcdk_depart' => 'd'))
            ->where($where)
            ->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();
        $allinfo=M('Sign_history')->field('u.username,s.user_id,u.sex,u.job_number,d.depart_name,s.sign_time,s.sign_date,s.sign_type')
            ->table(array('qcdk_sign_history'=>'s','qcdk_users'=>'u','qcdk_depart' => 'd'))
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        foreach ($allinfo as $k=>$v) {
            $where1['sign_date']  = $v['sign_date'];
            $where1['user_id']  = $v['user_id'];
            $where1['sign_type']  =2;
            $item = M('Sign_history')->field('sign_time')->where($where1)->find();
            $allinfo[$k]['xtime']=$item['sign_time'];
        }
        $this->assign('page',$show);
        $this->assign('keyword',$keyword);
        $this->assign('departss',$departs);
        $this->assign('sex',$sex);
        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);

        $this->assign('lists',$allinfo);
        $this->display();

    }

    public function abnormal()
    {
        $where['status'] = 1;
        $where['id'] =   ['in','12,13,20'];
        $this->assign('departs',M('Depart')->field('id,depart_name')->where($where)->select());
        $this->display();
    }
    //部门EXCEL
    public function DepartExt()
    {
        $strSDate = strtotime(I('get.dst'));
        $strEDate = strtotime(I('get.det'));
        $departId = I('get.did');
        $strEDate=  mktime(23,59,59,date('m',$strEDate),date('d',$strEDate),date('Y',$strEDate));
        $sign = M('Sign_history');
        //除去总经办的所有用户id
        $wh['depart_id'] = array('eq',$departId);

        $alluid = M('Users')->field('id')->where($wh)->select();
        //获取部门信息
        $dname = M('Depart')->where(['id'=>['eq',$departId]])->find();
        //查出选定范围内的所有日期
        $mothinfo = $sign->query("select * from (SELECT user_id,sign_type,sign_time,sign_date FROM qcdk_sign_history WHERE ( sign_time between '$strSDate' and '$strEDate')) as tmp GROUP BY sign_date  ORDER BY sign_time");
        //循环判断用户签到是否异常
        foreach($mothinfo as $k=>$m){
            foreach($alluid as $u){
                $uid = $u['id'];
                $where['id']=$uid;
                $stfinfo = M('Users')->field('job_number,username')->where($where)->find();
                $d = $m['sign_date'];
                $iswdk = $sign->where("user_id='$uid' and (sign_date='$d')")->count();
                $isQj = $sign->where("user_id='$uid' and (sign_date='$d') and (sign_type=2 and leave_reason <> '')")->find();//弹性部门请假
                $isFtxQj = $sign->where("user_id='$uid' and (sign_date='$d') and sign_type=2")->find();//非弹性部门请假迟到

                //未打卡
                if($iswdk==0){
                    $abnormal[] =[
                        'user_id'=>$uid,
                        'job_number'=>$stfinfo['job_number'],
                        'username'=>$stfinfo['username'],
                        'sign_date'=>date('n月j日',strtotime($d)),
                        'htime'=>'**：**',
                        'xtime'=>'**：**',
                        'leave_reason'=>'未打卡'
                    ];
                }

                if($iswdk ==1){//缺卡
                    $tinfo = $sign->where("user_id='$uid' and (sign_date='$d') and sign_type=1")->find();
                    if((strtotime(date('H:i',$tinfo['sign_time'])) > strtotime('09:00'))&&($departId==12 || $departId==13 || $departId==20)){//非弹性部门发到缺卡
                        $abnormal[] =[
                            'user_id'=>$uid,
                            'job_number'=>$stfinfo['job_number'],
                            'username'=>$stfinfo['username'],
                            'sign_date'=>date('n月j日',strtotime($d)),
                            'htime'=>date('H:i',$tinfo['sign_time']),
                            'xtime'=>'**：**',
                            'leave_reason'=>'缺卡 迟到',
                        ];
                    }else{//弹性部门缺卡
                        $abnormal[] =[
                            'user_id'=>$uid,
                            'job_number'=>$stfinfo['job_number'],
                            'username'=>$stfinfo['username'],
                            'sign_date'=>date('n月j日',strtotime($d)),
                            'htime'=>date('H:i',$tinfo['sign_time']),
                            'xtime'=>'**：**',
                            'leave_reason'=>'缺卡',
                        ];
                    }

                }
                //无弹性工作部门请假或迟到
                if($isFtxQj && $iswdk==2 && ($departId==12 || $departId==13 || $departId==20)){
                    $tinfo = $sign->where("user_id='$uid' and (sign_date='$d') and sign_type=1")->find();
                    //仅请假
                    if((strtotime(date('H:i',$tinfo['sign_time'])) <=strtotime('09:00')) &&($isFtxQj['leave_reason'] <>'')){
                    $abnormal[] =[
                        'user_id'=>$uid,
                        'job_number'=>$stfinfo['job_number'],
                        'username'=>$stfinfo['username'],
                        'sign_date'=>date('n月j日',strtotime($d)),
                        'htime'=>date('H:i',$tinfo['sign_time']),
                        'xtime'=>date('H:i',$isFtxQj['sign_time']),
                        'leave_reason'=>$isFtxQj['leave_reason'],
                    ];
                    }else if((strtotime(date('H:i',$tinfo['sign_time'])) > strtotime('09:00'))) {//迟到|请假
                        $abnormal[] = [
                            'user_id' => $uid,
                            'job_number' => $stfinfo['job_number'],
                            'username' => $stfinfo['username'],
                            'sign_date' => date('n月j日', strtotime($d)),
                            'htime' => date('H:i', $tinfo['sign_time']),
                            'xtime' => date('H:i', $isFtxQj['sign_time']),
                            'leave_reason' => "迟到   " . $isFtxQj['leave_reason'],
                        ];
                    };
                }else if($isQj && $iswdk==2 &&( $departId!==12 ||$departId!==13 ||$departId!==20)){//弹性工作部门请假
                    $tinfo = $sign->where("user_id='$uid' and (sign_date='$d') and sign_type=1")->find();
                    $abnormal[] =[
                        'user_id'=>$uid,
                        'job_number'=>$stfinfo['job_number'],
                        'username'=>$stfinfo['username'],
                        'sign_date'=>date('n月j日',strtotime($d)),
                        'htime'=>date('H:i',$tinfo['sign_time']),
                        'xtime'=>date('H:i',$isQj['sign_time']),
                        'leave_reason'=>$isQj['leave_reason'],
                    ];
                }
            }
        }
        //Excel格式设计
        $ex = D('Users');
        $ex->expDSign(I('get.dst'),I('get.det'),$abnormal,$dname['depart_name']);
    }
    //月EXCEL
    public function MonthExt()
    {
        $strSDate = strtotime(I('get.st'));
        $strEDate = strtotime(I('get.et'));
        $strEDate=  mktime(23,59,59,date('m',$strEDate),date('d',$strEDate),date('Y',$strEDate));
        $sign = M('Sign_history');
        //除去总经办的所有用户id
        $wh['depart_id'] = array('not in','18,12,13,20');
        $alluid = M('Users')->field('id')->where($wh)->select();
        //查出选定范围内的所有日期
        $mothinfo = $sign->query("select * from (SELECT user_id,sign_type,sign_time,sign_date FROM qcdk_sign_history WHERE ( sign_time between '$strSDate' and '$strEDate')) as tmp GROUP BY sign_date  ORDER BY sign_time");
        //用户签到是否异常

            foreach($mothinfo as $k=>$m){
                foreach($alluid as $u){
                    $uid = $u['id'];
                    $where['id']=$uid;
                    $stfinfo = M('Users')->field('job_number,username')->where($where)->find();
                $d = $m['sign_date'];
                $iswdk = $sign->where("user_id='$uid' and (sign_date='$d')")->count();
                $isQj = $sign->where("user_id='$uid' and (sign_date='$d') and sign_type=2 and leave_reason <> '' ")->find();
                if($iswdk==0){
                    $abnormal[] =[
                        'user_id'=>$uid,
                        'job_number'=>$stfinfo['job_number'],
                        'username'=>$stfinfo['username'],
                        'sign_date'=>date('n月j日',strtotime($d)),
                        'leave_reason'=>'未打卡'
                    ];
                }
                if($iswdk ==1){
                    $abnormal[] =[
                        'user_id'=>$uid,
                        'job_number'=>$stfinfo['job_number'],
                        'username'=>$stfinfo['username'],
                        'sign_date'=>date('n月j日',strtotime($d)),
                        'leave_reason'=>'缺卡',
                    ];
             }
                if($isQj && $iswdk==2){
                    $abnormal[] =[
                        'user_id'=>$uid,
                        'job_number'=>$stfinfo['job_number'],
                        'username'=>$stfinfo['username'],
                        'sign_date'=>date('n月j日',strtotime($d)),
                        'leave_reason'=>$isQj['leave_reason'],
                    ];
                }
            }
        }
        //Excel格式设计
        $ex = D('Users');
        $ex->expSign(I('get.st'),I('get.et'),$abnormal);
    }
}