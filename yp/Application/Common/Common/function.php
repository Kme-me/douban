<?php
/**
 * 公用的方法
 * @author sunchao <[sss9892100@qq.com]>
 */
function show($status, $message, $data = array()) {
	$reuslt = array(
		'status' => $status,
		'message' => $message,
		'data' => $data,
	);

	exit(json_encode($reuslt));
}

function getMd5Password($password) {
	return md5($password . C('MD5_PRE'));
}

function getMenuType($type) {
	return $type == 1 ? '后台菜单' : '前端导航';
}

function status($status) {
	if ($status == 0) {
		$str = '关闭';
	} elseif ($status == 1) {
		$str = '正常';
	} elseif ($status == -1) {
		$str = '删除';
	}
	return $str;
}

function getAdminMenuUrl($nav) {
	$url = '?c=' . $nav['c'] . '&a=' . $nav['a'];
	if ($nav['f'] == 'index') {
		$url = '?c=' . $nav['c'];
	}
	return $url;
}

function getActive($navc) {
	$c = strtolower(CONTROLLER_NAME);
	if (strtolower($navc) == $c) {
		return 'class="active"';
	}
	return '';
}

function showKind($status, $data) {
	header('Content-type:application/json;charset=UTF-8');
	if ($status == 0) {
		exit(json_encode(array('error' => 0, 'url' => $data)));
	}
	exit(json_encode(array('error' => 1, 'message' => '上传失败')));
}

function getLoginUsername() {
	return $_SESSION['adminUser']['username'] ? $_SESSION['adminUser']['username'] : '';
}

function getCatName($navs, $id) {
	foreach ($navs as $nav) {
		$navList[$nav['menu_id']] = $nav['name'];
	}
	return isset($navList[$id]) ? $navList[$id] : '';
}

function getCopyFromById($id) {
	$copyFrom = C("COPY_FROM");
	return $copyFrom[$id] ? $copyFrom[$id] : '';
}

function isThumb($thumb) {
	if ($thumb) {
		return '<span style="color:red">有</span>';
	}
	return '无';
}

//获得年级的列表
function getNjById($id) {
	$nj = C("SCHOOL_NIANJI");
	return $nj[$id] ? $nj[$id] : '';
}
//获得科目的列表
function getKmById($id) {
	$nj = C("SCHOOL_KEMU");
	return $nj[$id] ? $nj[$id] : '';
}
?>