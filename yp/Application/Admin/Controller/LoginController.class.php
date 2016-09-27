<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

	public function index() {
		if (session('adminUser')) {
			$this->redirect('index/index');
		}

		return $this->display();
	}

	public function check() {
//    	echo "成功";
		//        print_r($_POST);

		$username = $_POST['username'];
		$password = $_POST['password'];

		if (!trim($username)) {
			return show(0, '用户为空');
		}
		if (!trim($password)) {
			return show(0, '密码为空');
		}

		$ret = D('Admin')->getAdminByUsername($username);
//        print_r(getMd5Password($password));
		//        print_r($ret);

		if (!$ret || $ret['status'] != 1) {
			return show(0, '该用户不存在');
		}
		if ($ret['password'] != getMd5Password($password)) {

			return show(0, '密码错误');
		}

		D("Admin")->updateByAdminId($ret['admin_id'], array('lastlogintime' => time()));
		session('adminUser', $ret);
		return show(1, "登录成功");

	}

	public function loginout() {
//登录退出
		session('adminUser', null);
		$this->redirect('index');//自动跳转到index
	}

}