<?php
/**
 *文章内容的存储操作
 *@author sunchao <[sss9892100@qq.com]>
 */

namespace Common\Model;
use Think\Model;

class VideoModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('Video');
	}

	public function insert($data = array()) {
		if (!is_array($data) || !$data) {
			return 0;
		}
		$data['create_time'] = time();
		$data['username'] = getLoginUsername();
//        print_r($data);

		return $this->_db->add($data);
	}

	public function getVideo($data, $page, $pageSize = 10) {
		$conditions = $data;

		//      if(isset($data['njkey']) && $data['njkey']){
		//          $conditions['njkey'] = array('like','%'.$data['njkey'].'%');
		//      }
		//      if(isset($data['km']) && $data['km']){
		//          $conditions['km'] = array('like','%'.$data['km'].'%');
		//      }
		if (isset($data['school_ls']) && $data['school_ls']) {
			$conditions['school_ls'] = array('like', '%' . $data['school_ls'] . '%');

		}

		//$conditions['status'] = array('neq', -1);
		$offset = ($page - 1) * $pageSize;

		$list = $this->_db->where($conditions)
		             ->order('listorder desc ,id desc')
		             ->limit($offset, $pageSize)
		             ->select();
		return $list;
	}
	public function getVideoCount($data = array()) {
		$conditions = $data;
		if (isset($data['njkey']) && $data['njkey']) {
			$conditions['njkey'] = array('like', '%' . $data['njkey'] . '%');
		}
		if (isset($data['km']) && $data['km']) {
			$conditions['km'] = array('like', '%' . $data['km'] . '%');
		}
		if (isset($data['school_ls']) && $data['school_ls']) {
			$conditions['school_ls'] = array('like', '%' . $data['school_ls'] . '%');
		}
		$conditions['status'] = array('neq', -1);

		return $this->_db->where($conditions)->count();
	}
     

    
}