<?php 
namespace Admin\Controller;
use Common\Controller\ABaseController;
use Think\Db;
class DataController extends ABaseController { 
    public function index(){
    	$Db = Db::getInstance();
		$lists = $Db->query('SHOW TABLE STATUS');

		foreach($lists as $key => $val){
				$size += $val['data_length']+$val['index_length'];
				$lists[$key]['size'] = bytes_format($size);
				$lists[$key]['table_name'] =$val['name'];
			}


		 $this->assign('lists',$lists);
         $this->display();
    }

    public function reduction(){
      
            $path = C('BACK_PATH');
            if(!is_dir($path)){
                mkdir($path);
            }
              $flag = \FilesystemIterator::KEY_AS_FILENAME;
              $glob = new \FilesystemIterator($path,  $flag);
              //dump($glob);
              $lists =array();
              foreach($glob as $name =>$file){
                if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
    
                            $info['name'] = $name;
                            $namef = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
                            $date = "{$namef[0]}-{$namef[1]}-{$namef[2]}";
                            $time = "{$namef[3]}:{$namef[4]}:{$namef[5]}";
                            $part = $namef[6];
                             
                             $info['name'] = $name;
                             $info['table_name'] = $name;
                             $info['part'] = $part;
                             $info['size'] = bytes_format($file->getSize());
                             $info['compress'] =pathinfo($file->getFilename(),PATHINFO_EXTENSION);
                             $info['time'] = "{$date} {$time}";
                             $lists[]= $info;
    //                      dump($list);
                }           
                 
              }
              // dump($lists);exit();
             $this->assign('lists',$lists);
             $this->display();
        
    }

    public function backUp(){//数据备份
    	$tables = I('post.tables');
    	if (is_string($tables)) {
    		$tables = explode(',', $tables);//单数据表
    	}
    	
		$start =0;
	 	if(IS_POST){ //初始化
            $path = C('BACK_PATH');
            if(!is_dir($path)){
                mkdir($path, 0755, true);
            }
            //读取备份配置
            $config = array(
                'path'     => C('BACK_PATH'),
                'part'     => C('BACK_PART'),
                'compress' => C('BACK_COMPRESS'),
                'level'    => C('BACK_LEVEL'),
            );
		

            //检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                $this->error('检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                //创建锁文件
                file_put_contents($lock, NOW_TIME);
            }

            //检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写，请检查后重试！');
            session('backup_config', $config);

            //生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', NOW_TIME),
                'part' => 1,
            );
            session('backup_file', $file);

            //缓存要备份的表
            session('backup_tables', $tables);

            //创建备份文件
            $Database = new \Org\Util\Database($file, $config);
            if(false !== $Database->create()){
            //备份开始 
			   foreach($tables as $k =>$v){
			   	  
                 $res =  $Database->backup($tables[$k], $start);
				
			   }

               if ($res === false) {
                   aWriteLog('备份数据',0);
                   $this->error('备份失败');
               }else{
                   unlink(session('backup_config.path') . 'backup.lock');
                   session('backup_tables', null);
                   session('backup_file', null);
                   session('backup_config', null);
                   aWriteLog('备份数据',1);
                   $this->success('备份成功');
               }
			   
			 

            } else {
                $this->error('初始化失败');
            }
        } 

    }


    public function import(){
        $start =0;
        $name = I('post.name');//文件名
        $part = I('post.part');//
        $compress = I('post.compress');
        $path = C('BACK_PATH').$name;//文件路径
        $match = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');
        $gz = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $name);
      
        $file =array($match[6],$path,$gz);
        
        if ($compress == 'sql') {
            $compressF = 0;
        }else{
            $compressF=  1;
        }
        //读取备份配置
        $config = array(
                'path'     => C('BACK_PATH'),
                'compress' => $compressF
        );
          $Database = new \Org\Util\Database($file, $config);
 


             if(count($file) === 3){//检测文件完整性
           
                     $res = $Database->import($start);
                     if ($res === false) {
                        aWriteLog('还原数据',0);
                         $this->error('还原失败');
                     }else{
                         aWriteLog('还原数据',1);
                         $this->success('还原成功');
                     }
               

            } else {
                aWriteLog('还原数据失败,文件不完整',0);
                $this->error('初始化失败,请检查文件完整性');
            }
    }

    public function optimization(){
        if(IS_POST) {
            $tables = I('post.tables');
            $Db   = Db::getInstance();
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
             }   

            $res = $Db->query("OPTIMIZE TABLE `{$tables}`");
            if ($res) {
                   aWriteLog('数据优化',1);
                   $this->success('数据优化成功');
            }else{
                   aWriteLog('数据优化',0);
                   $this->success('数据优化失败');
            }
                        
        } else {
            $this->error('无效数据');
        }
            
    }

    public function repair(){
        if(IS_POST) {
            $tables = I('post.tables');
            $Db   = Db::getInstance();
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
             }   
            $res = $Db->query("REPAIR TABLE `{$tables}`");
            if ($res) {
                   aWriteLog('数据修复',1);
                   $this->success('数据修复成功');         # code...
            }else{
                   aWriteLog('数据修复',0);
                   $this->success('数据修复失败');
            }          
                
        } else {
             $this->error('无效数据');
        }
    }



    public function del(){
        $tables = I('post.tables');
        $flag = 0;
        if (is_string($tables)) {
            $tables =explode(',', $tables);
        }
        // dump($tables);exit();
            foreach ($tables as $key => $val) {
               $file_path = C('BACK_PATH').$val;
               if (file_exists($file_path)) {
                   if (unlink($file_path)) {
                    
                    $flag = 1;
                   }
               }else{
                $flag = 0;
               }
            }
         if ($flag === 1) {
             $this->success('备份删除成功');
         }else{
            $this->error('要删除的文件不存在');
         }
    }

}