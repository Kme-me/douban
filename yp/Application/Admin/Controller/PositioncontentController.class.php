<?php
/**
 * 菜单中推荐位内容管理的控制器
 * @author sunchao <[sss9892100@qq.com]>
 */

namespace Admin\Controller;
use Think\Controller;

class PositioncontentController extends CommonController {
	public function index() {
		$positions = D("Position")->getNormalPositions();

		//获取推荐位里面的内容
		$data['status'] = array('neq', -1);
		if ($_GET['title']) {
			//print_r($_GET['title']);exit;
			$data['title'] = trim($_GET['title']);
			//print_r($data['title']);exit;
			$this->assign('title', $data['title']);
		}
		$data['position_id'] = $_GET['position_id'] ? intval($_GET['position_id']) : $positions[0]['id'];
		$contents = D("PositionContent")->select($data);
		$this->assign('positions', $positions);
		$this->assign('contents', $contents);
		$this->assign('positionId', $data['position_id']);//搜索的有关代码
		$this->display();
	}

	public function add() {
		if ($_POST) {
			if (!isset($_POST['position_id']) || !$_POST['position_id']) {
				return show(0, '推荐位ID不能为空');
			}
			if (!isset($_POST['title']) || !$_POST['title']) {
				return show(0, '推荐位标题不能为空');
			}
			if (!$_POST['url'] && !$_POST['news_id']) {
				return show(0, 'url和news_id不能同时为空');
			}
			if (!isset($_POST['thumb']) || !$_POST['thumb']) {
				if ($_POST['news_id']) {
					$res = D("News")->find($_POST['news_id']);
					if ($res && is_array($res)) {
						$_POST['thumb'] = $res['thumb'];
					}
				} else {
					return show(0, '图片不能为空');
				}
			}
			if ($_POST['id']) {
				return $this->save($_POST);
			}
			try {
				$id = D("PositionContent")->insert($_POST);
				if ($id) {
					return show(1, '新增成功');
				}
				return show(0, '新增失败');
			} catch (Exception $e) {
				return show(0, $e->getMessage());
			}
		} else {
			$positions = D("Position")->getNormalPositions();
			$this->assign('positions', $positions);
			$this->display();
		}
	}

	public function edit() {

		$id = $_GET['id'];
		if (!id) {
			//执行跳转
			$this->redirect('/tyhcms/admin.php?c=positioncontent');
		}
		$position = D("PositionContent")->find($id);
		$positions = D("Position")->getNormalPositions();

		$this->assign('positions', $positions);
		$this->assign('vo', $position);

		$this->display();
	}

	public function save($data) {
		$id = $data['id'];
		unset($data['id']);

		try {
			$resId = D("PositionContent")->updateById($id, $data);
			if ($resId === false) {
				return show(0, '更新失败');
			}
			return show(1, '更新成功');
		} catch (Exception $e) {
			return show(0, $e->getMessage());
		}
	}

	public function setStatus() {
		try {
			if ($_POST) {
				$id = $_POST['id'];
				$status = $_POST['status'];
				if (!$id) {
					return show(0, 'ID不存在');
				}
				$res = D("PositionContent")->updateStatusById($id, $status);
				if ($res) {
					return show(1, '操作成功');
				} else {
					return show(0, '操作失败');
				}
			}
			return show(0, '没有提交内容');
		} catch (Exception $e) {
			return show(0, $e->getMessage());
		}
	}

	public function listorder() {
		$listorder = $_POST['listorder'];
		$jumpUrl = $_SERVER['HTTP_REFERER'];
		$errors = array();
		if ($listorder) {
			try {
				foreach ($listorder as $id => $v) {
					//执行更新
					$list = D('PositionContent')->updataPositioncontentListorderById($id, $v);
					if ($list === flase) {
						$errors[] = $id;
					}
				}
			} catch (Exception $e) {
				return show(0, $e->getMessage(), array('jump_url' => $jumpUrl));

			}
			if ($errors) {
				return show(0, '排序失败-' . implode(',', $errors), array('jump_url' => $jumpUrl));
			}
			return show(1, '排序成功', array('jump_url' => $jumpUrl));
		}
		return show(0, '排序数据失败', array('jump_url' => $jumpUrl));
	}

}
