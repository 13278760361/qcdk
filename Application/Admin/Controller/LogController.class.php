<?php 
namespace Admin\Controller;
use Common\Controller\ABaseController;
class LogController extends ABaseController { 
     public function _initialize(){
      parent::_initialize();
      $this->db = M('AdminLog'); //当前模块数据库
    } 

    public  function user(){
         //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        $group   = I('get.group')?I('get.group'):'';

        $count          = $this->db->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show           = $page->show();
     

        $lists = $this->db->order('time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
   }

   public function admin(){
     //查询条件匹配
        $keyword = I('get.keyword')?I('get.keyword'):'';
        // $group   = I('get.group')?I('get.group'):'';


        if (empty($keyword)) {
          $where = "";
        }elseif ($keyword) {
          $where = "action_user like '%{$keyword}%'";
        }

        $count          = $this->db->where($where)->count();
        $page           = new \Think\Page($count,C('pageNum'));
        $show           = $page->show();
     

        $lists = $this->db->where($where)->order('time desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('keyword',$keyword);
        $this->assign('page',$show);
        $this->assign('lists',$lists);
        $this->display();
   }

   public function del(){
    $ids = I('post.ids');
    $map['id'] = array('IN',$ids);
    $res = $this->db->where($map)->delete();
      if ($res) {
          aWriteLog('删除后台日志',1);
          $this->success('删除成功');
      }else{
          aWriteLog('删除后台日志',0);
          $this->success('删除失败');
      }
   }
}