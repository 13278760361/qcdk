<?php
namespace Admin\Controller;
use Common\Controller\ABaseController;
class NodeController extends ABaseController{
    public function _initialize(){
      parent::_initialize();
      $this->db = M('Admin_auth_rule'); //当前模块数据库
      $this->nodes = $this->db->field('id,title')->where('pid =0')->select();//根节点
      $this->assign('nodes',$this->nodes);

      $Category = new \Org\Util\Category('Admin_auth_rule',array('id','pid','title'));
      $this->nodes = $Category->getList('',0,'sort asc');
      
      $this->assign('nodes',$this->nodes);
    }

    public function index(){ 
     
        
		 $lists = $this->nodes;

	
         foreach ($lists as $key=> $v) {
         	if ($v['pid'] == 0) {
         		$lists[$key]['sort'] = "<font color='red' style='font-size:15px;'>".$v['sort']."</font>" ;
         	}//根节点排序样式变化
         }
	      $this->assign('lists',$lists);
		  $this->display();
    }

     public function add(){
       if (IS_POST) {
            $data['name']         = I('post.name');
            $data['pid']          = I('post.pid');
            $data['title']        = I('post.title');
            $data['condition']    =I('post.condition');
            $data['status']        = I('post.status');
            $data['sort']         = I('post.sort');
            $data['icon']         =I('post.icon');
            $data['create_time']  = time();
            //$this->success('添加成功!');
            $res = $this->db->add($data);
            if ($res) {
              //日志记录
                aWriteLog('添加节点--'.$data['title'],1);
                $this->success('添加成功');
            }else{
                //日志记录
                aWriteLog('添加节点--'.$data['title'],0);
                $this->error('添加失败');
            }
    
        }else{
           
           $this->display();
        }
   }

     public function edit(){
        $id = I('get.id');
        if (IS_POST) {
            # code...   
            $data['id']           = I('post.id');
            $data['name']         = I('post.name');
            $data['pid']          = I('post.pid');
            $data['title']        = I('post.title');
            $data['condition']    = I('post.condition');
            $data['status']        = I('post.status');
            $data['sort']         = I('post.sort');
            $data['icon']         =I('post.icon');
            $res = $this->db->where('id='.$data['id'])->save($data);
            if ($res!==false) {
                //日志记录
                 aWriteLog('编辑节点--'.$data['title'],1);
                 $this->success('修改成功');
                }else{
                //日志记录
                 aWriteLog('编辑节点--'.$data['title'],0);
                    $this->error('修改失败');
            }
        }else{      
            $info = $this->db->where('id='.$id)->find();
            $this->assign('info',$info); 
            $this->display();
        }
   }

   public function del(){
    $id = I('post.ids');
    if ($this->db->where('pid='.$id)->find()) {
        $this->error('请先删除子节点');
    }
    $res = $this->db->where('id='.$id)->delete();
    if ($res) {
        //日志记录
        aWriteLog('删除节点',1);
        $this->success('删除成功');
    }else{
        //日志记录
        aWriteLog('删除节点',0);
        $this->error('删除失败');
    }
   }

   public function icons(){
     $this->display();
   }
}