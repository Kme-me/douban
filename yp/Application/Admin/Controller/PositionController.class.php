<?php
/**
 * 菜单中推荐位管理的控制器
 * @author sunchao <[sss9892100@qq.com]>
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class PositionController extends CommonController{
	public function index(){
		$data = array();
		$polists = D("Position")->getNormalPositions($data);
		$this->assign('polists',$polists);
		$this->display();
	}
}
