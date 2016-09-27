<?php
namespace Common\Model;
use Think\Model;

/**
 * 推荐位Model的操作
 * @author sunchao <[sss9892100@qq.com]>
 */

class PositionModel extends Model{
	private $_db = '';

	public function __construct(){
		$this->_db = M('position');
	}

	public function select($data = array()){
		$conditions =$data;
		$list = $this->_db->where($conditions)->order('id')->select();
		return $list;
	}

	public function find($id){
        if(!$id || !is_numeric($id)){
            return array();
        }
		$data = $this->_db->where('id='.$id)->find();
        return $data;
	}

    public function insert($data=array()){
        if(!is_array($data) || !$data){
            return 0;
        }
        $data['create_time'] = time();
        return $this->_db->add($data);
    }

	public function updateById($id,$data){
        if(!$id || !is_numeric($id)){
            throw_exception('ID不合法');
        }
        if(!$data || !is_array($data)){
            throw_exception('更新的数据不合法');
        }
        return $this->_db->where('id='.$id)->save($data);
	}
	//获取正常的推荐位内容
	public function getNormalPositions(){
		$conditions = array('status'=>1);
		$list = $this->_db->where($conditions)->order('id')->select();
		return $list;
	}

	public function getCount($data=array()) {
		$conditions = $data;
		$list = $this->_db->where($conditions)->count();

		return $list;
	}
	/**
	 * 通过id更新的状态
	 * @param $id
	 * @param $status
	 * @return bool
	 */
	public function updateStatusById($id, $status) {
		if(!is_numeric($status)) {
			throw_exception("status不能为非数字");
		}
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		$data['status'] = $status;
		return  $this->_db->where('id='.$id)->save($data); // 根据条件更新记录

	}

}

?>