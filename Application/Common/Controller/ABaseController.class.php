<?php 
namespace Common\Controller;
/**
* 后台底层控制器
*/
class ABaseController extends BackController
{
	
	function _initialize(){
	   parent::_initialize();

	   $this->admin_id = (int)session('admin_id');
	    
         
	    if ($this->admin_id <1) {
	    	redirect(U('Public/login'));
	    }

	    $userInfo = M('Admin_user')->where('id='.$this->admin_id)->find();

	    if($userInfo['status'] == 0){
	    	$this->error('您的账号已冻结,请联系管理员',U('Admin/Public/login'));
	    }


	    if($userInfo['login_key'] !== session('admin_login_key')){
	    	$this->error('您的帐号在别的地方登录',U('Admin/Public/login'));
	    }

	    $this->group_name = $this-> show_group_name($this->admin_id);
        
        $pid = I('get.pid',1);
		$this->menu = $this->show_menu($pid); //菜单
        // dump($this->menu);
        
        //如果是超级管理员，不进行权限认证
        if(in_array($this->admin_id,C('AUTH_CONFIG.AUTH_ADMINUID'))) return true;

	    $auth = new \Think\Auth();
		if(!$auth->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$this->admin_id)){
			$this->error('没有权限');
		}

		
	
	}


    //获取分组名称
    public function show_group_name($uid){
    	$group_name = $this->group_name = M('admin_auth_group_access a')->join('__ADMIN_AUTH_GROUP__ g ON a.group_id=g.id')->where(array('a.uid'=>$uid))->getField('g.title');
    	return $group_name;
    }

    //获取分组ID
    public function show_group_id($uid){
     $group_id = M('admin_auth_group_access')->where('uid='.$uid)->getField('group_id');
     return $group_id;
    }


    //获取菜单
	public function show_auth_list(){

       $group_id = $this->show_group_id($this->admin_id);

       $rules = M('Admin_auth_group')->where('id =' .$group_id)->getField('rules');//获取规则列表

       if (in_array($this->admin_id,C('AUTH_CONFIG.AUTH_ADMINUID'))) {//超级管理员获取所有

        $map['status'] = 1;
       }else{
       	$map['status'] =1;
        $map['id'] =array(array('in',$rules));
       }

       $list = M('Admin_auth_rule')->where($map)->order('sort asc')->select();

       return $list;
	}

   //获取菜单列表
	public function show_menu($pid = 0){
		$node = $this->show_auth_list();
		$pid =$pid?$pid:1; 
		$menu = array();
		foreach ($node as $key =>$v) {
			$url =   explode('/', $v['name']); //生成节点URL
			if ($v['pid'] == 0) { //顶级菜单
				$menu['top'][$key] = $v;
				$menu['top'][$key]['url'] = U("{$url[0]}/{$url[1]}/$url[2]",array('pid'=>$v['id']));          
                if ($pid == $v['id']){
                        $menu['top'][$key]['css'] = "active"; 
                }
			}

			if ($v['pid'] == $pid) {//二级菜单 $_GET['leve'] == on 时 开启多级菜单 控制器要唯一
            $menu['son'][$key] =$v;      
            $menu['son'][$key]['url'] = U("{$url[0]}/{$url[1]}/$url[2]",array('pid'=>$v['pid']));
                if($_GET['leve'] == "on"){
                    if (CONTROLLER_NAME == $url[1]) {
                        $menu['son'][$key]['css'] = "active";
                    }
                }else{
                   if (CONTROLLER_NAME == $url[1] && ACTION_NAME == $url[2]) {
                        $menu['son'][$key]['css'] = "active";
                    }
                 }
                
               
           }

		}
        
		return $menu;
	}


	protected function all_insert($name = '', $back = '/index'){
        $name = $name?$name:MODULE_NAME;
        $db = D($name);
        $db->startTrans();//开启事物
        $res_1 = $db -> create();

        if($res_1 === false){
            $this -> error($db -> getError());
        }else{
            $id = $db -> add();
            if($id){
                $m_arr = array('Text','Richtext');
                if(in_array($name, $m_arr)){
                  $res_2 =  $this -> handleKeyword($id, $name, $_POST['keyword'],'add');
                }elseif ($name = 'Areply') { //关注回复
                    $res_2 =true;
                }

                  if ( $res_1 && $res_2 ) {
                    $db->commit();
                    $this -> success('操作成功', U(MODULE_NAME . $back));
                  }else{
                    $db->rollback();
                    $this -> success('操作失败', U(MODULE_NAME . $back));
                  }

                // $this -> success('操作成功', U(MODULE_NAME . $back));
            }else{
                $this -> error('操作失败', U(MODULE_NAME . $back));
            }
        }
    }

    protected function all_save($name = '', $back = '/index'){
        $name = $name?$name:MODULE_NAME;
        $db = D($name);
        if($db -> create() === false){
            $this -> error($db -> getError());
        }else{
            $id = $db -> save();
            if($id){
                $m_arr = array('Text','Richtext');
                if(in_array($name, $m_arr)){
                    $this -> handleKeyword(intval($_POST['id']), $name, $_POST['keyword'],'edit');
                }
                $this -> success('操作成功', U(MODULE_NAME . $back));
            }else{
                $this -> error('操作失败', U(MODULE_NAME . $back));
            }
        }
    }

     public function handleKeyword($id, $module, $keyword = '',$operation){
        $db = M('Keyword');
        if ($operation == 'add') {
            if ( $db->where(array('keyword'=>$keyword))->find() ) {
                $this->error('关键词已存在');
                  return false;
            }
            $data['pid'] = $id;
            $data['module'] = $module;
            $data['keyword'] = $keyword;
            $db->add($data);  
               return true;
        }elseif ($operation == 'edit') {
            $data['pid'] = $id;
            $data['module'] = $module;
            $data['keyword'] = $keyword;
            $db->where(array('pid'=>$data['pid']))->save($data);
        }
       
       
    }



}

?>