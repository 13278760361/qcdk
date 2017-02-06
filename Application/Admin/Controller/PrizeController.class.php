<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;

class PrizeController extends ABaseController
{
	
	public function _initialize(){
        parent::_initialize();
        $this->db = M('Users'); //当前模块数据库
        $this->assign('departs', M('Depart')->where(array('status'=>1))->getField('id,depart_name'));
        $this->assign('type',array('红包','拼图','假期','名言'));
    
    }
    public function index(){
         //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $sceneid = I('get.id');
        $where =1;
        if ($keyword) {
            $where ="prize_name like '%{$keyword}%'";
        }
        if(!empty($sceneid)){
        	$where.=" AND s.id=p.scene_id AND s.id=${sceneid}";
        }
        $prize = M('Prize');
        $count          =  $prize->table(array('qcdk_prize'=>'p','qcdk_scene'=>'s'))->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();
        
        $prizeList = M('Prize')->field('p.id,p.scene_id,p.prize_name,p.type,p.money,p.num,p.pic,p.prob,p.status,s.scene_name')->table(array('qcdk_prize'=>'p','qcdk_scene'=>'s'))->where($where) ->limit($page->firstRow.','.$page->listRows)->select();
       // print_r($prizeList);exit;
      
        if(!empty($prizeList)){
               foreach($prizeList as $k=>$v){
                    
                    if ($v['pic']!=='prize-1477555084.jpg') {
                       $prizeList[$k]['pic'] = "/Uploads/prize/".$v['pic'];
                    }else{
                        $prizeList[$k]['pic'] = C('DEFAULT_IMG');
                    }
                    
               } 
        }
        $this->assign('keyword',$keyword);
        $this->assign('sc_id',I('get.id'));
        $this->assign('page',$show);
        $this->assign('lists',$prizeList);
        $this->display();

        //  $lists =  $prize      
        
        // ->limit($page->firstRow.','.$page->listRows)
        // ->where($where)
        // ->order('id DESC')
        // ->select();
        // $this->assign('keyword',$keyword);
        // $this->assign('page',$show);
        // $this->assign('lists',$lists);
        // $this->display();
    }
    //添加奖品
    public function add(){

    	$scene = M('Scene');
    	if (IS_POST) {
    		# code...
    		$data['scene_id'] = I('post.scene_id');
    		$data['prize_name'] = I('post.prize_name');
    		$data['prob'] = I('post.prob');
    		$data['num'] = I('post.num');
    		$data['type'] = I('post.type_id');
            if(I('post.money')!==""){
                $data['money'] = I('post.money');
            }
    		$data['status'] = I('post.status');
            $data['pic'] = explode('/',I('post.prize_pic'))[3];
           // print_r($data['pic']);exit;
            if($data['pic'] == 'images'){
                $data['pic'] = explode('/',I('post.prize_pic'))[4];
            }
    		$re = M('Prize')->add($data);
    		if($re){
    			$this->success('添加成功!');
    		}else{
				$this->error('添加失败!');
    		}
    	}else{
    		//print_r(I('get.s_id'));exit;
    		$info = $scene->where(array('id'=>$_GET['id']))->find();
    		$this->assign('info',$info);
    		
    		$this->assign('ids',I('get.id'));
    		$this->display();
    	}
    }
    //修改奖品
    public function edit(){
        if(IS_POST){
           $data['scene_id'] = I('post.scene_id');
            $data['prize_name'] = I('post.prize_name');
            $data['prob'] = I('post.prob');
            $data['num'] = I('post.num');
            $data['type'] = I('post.type_id');
            
            if(I('post.money')!=""){
                 $data['money'] = I('post.money');
            }else{
                $data['money'] = null;
            }
            $data['status'] = I('post.status');
            $data['pic'] = explode('/',I('post.prize_pic'))[3];
            // if(M('Prize')->where(array('prize_name'=>$data['prize_name']))){
            //     $this->error('奖品名称已存在，请重新操作');
            // }
            if($data['pic'] == 'images'){
                $data['pic'] = explode('/',I('post.prize_pic'))[4];
            }
            $where['id'] = I('post.id');

           $re = M('Prize')->where($where)->save($data);
         //echo  M('Prize')->getLastSql();die;
           if($re){
               $this->success('修改成功!');
           } else {
               $this->error('修改失败,请重试');
           }
       }else{
           $where['id'] = I('get.id');
           $info = M('Prize')->where($where)->find();
        if($info['pic'] !=='prize-1477555084.jpg'){
            $info['pic'] = "/Uploads/prize/".$info['pic'];
        }else{
            $info['pic'] = C('DEFAULT_IMG');
        }
        
          
           $this->assign('sceneList',M('Scene')->where(array('status'=>1))->select());
           $this->assign('info',$info);
           $this->display();
       }
    }
    //删除奖品
    public function del(){
        $ids = I('post.ids');
        $map['id']=['in',$ids];
        $map2['prize_id'] = ['in',$ids];
        //$map1['scene_id']=['in',$ids];
        M('Prize')->startTrans();//开始事务
        $re = M('Prize')->where($map)->delete();
        if($re){
            M('Prize')->commit();
            M('Prize_record')->where($map2)->delete();//删除奖品下面的中奖记录
            $this->success('删除成功');
        } else {
            M('Prize')->rollback();
            $this->error('删除失败,请重试!');
        }
    }
    public function red_index(){
         //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';

        $where =1;
         if ($keyword) {
            $where ="scene_name like '%{$keyword}%'";
        }
        $redenvel = M('Scene');
        $count          =  $redenvel->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();

         $lists =  $redenvel      
        ->limit($page->firstRow.','.$page->listRows)
        ->where($where)
        ->order('id ASC')
        ->select();
        $this->assign('keyword',$keyword);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
    }
    public function red_add(){
        $scene = M('Scene');
        if(IS_POST){
           $data['scene_name'] = I('post.scene_name');
          
           $data['status'] = I('post.status');
           $data['time'] = $data['update_time'] =time();
           $re = $scene->add($data);
            if($re){
                $this->success('添加成功!');
            } else {
                $this->error('添加失败!');
            }
        }else{
            $this->display();
        }
    }
    //删除场景
    public function red_del(){
        $ids = I('post.ids');
        $map['id']=['in',$ids];
        $map1['scene_id']=['in',$ids];
        M('Scene')->startTrans();
        $re = M('Scene')->where($map)->delete();
        $re_1 = M('Prize')->where($map1)->count();
        if($re && empty($re_1)){
            M('Scene')->commit();
            $this->success('删除成功');
        }elseif($re_1){
            M('Scene')->rollback();
            $this->success('场景下面有奖品,请先删除奖品');
        } else {
            M('Scene')->rollback();
            $this->error('删除失败,请重试!');
        }
    }
    //场景修改
    public function red_edit(){
        if(IS_POST){
           $data['scene_name'] = I('post.scene_name');
          // $data['orders'] = I('post.order');
           $data['status'] = I('post.status');
           $data['time'] = time();
           $where['id'] = I('post.id');
           $re = M('Scene')->where($where)->save($data);
           if($re){
               $this->success('修改成功!');
           } else {
               $this->error('修改失败,请重试');
           }
       }else{
           $where['id'] = I('get.id');
           $info = M('Scene')->where($where)->find();
           $this->assign('info',$info);
           $this->display();
       }
    }
    //中奖列表
    public function record_list(){
        $record = M('Prize_record');
        //$recordlist = ->where(array('prize_id'=>I('get.id')))->select();
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $departs   = I('get.departs')?I('get.departs'):'';
        $sex   = I('get.sex')?I('get.sex'):'';
        // if ($keyword) {
        //     $where ="prize_name like '%{$keyword}%'";
        // }
        // if(!empty($sceneid)){
        //     $where.=" AND s.id=p.scene_id AND s.id=${sceneid}";
        // }
        
        $prize_id = I('get.id');
        $where = "pr.user_id=u.id AND u.depart_id=d.id AND pr.prize_id=p.id AND pr.prize_id=$prize_id ";
        if(!empty($keyword)){
            $where.="AND (u.job_number like '%{$keyword}%' OR u.username like '%{$keyword}%')";
        }
        if($departs){
            $where.=" and u.depart_id ={$departs}";
        }
        if($sex){
            if($sex==3){
                $where.=" and u.sex =0";
            }else{
                $where.=" and u.sex={$sex}";
            }
        }
        $count          =  $record->table(array('qcdk_prize_record'=>'pr','qcdk_users'=>'u','qcdk_depart'=>'d','qcdk_prize'=>'p'))->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();
        
        $recordlist = M('Prize_record')->field('pr.id,pr.user_id,pr.time,u.username,u.phone,u.wx_nickname,u.headimgurl,u.sex,u.job_number,u.depart_id,d.depart_name,p.money,p.type')->table(array('qcdk_prize_record'=>'pr','qcdk_users'=>'u','qcdk_depart'=>'d','qcdk_prize'=>'p'))->order('pr.time DESC')->where($where) ->limit($page->firstRow.','.$page->listRows)->select();
        
        $this->assign('page',$show);
        $this->assign('lists',$recordlist);
        $this->display();
    }
}
?>