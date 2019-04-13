<?php
namespace Home\Controller;

use Think\Controller;

class LoginController extends Controller
{
	public function signUp()
	{
		$this -> display();
	}

	public function register()
	{
		$_POST['created_at'] = time();
		$upwd = $_POST['upwd'];
		//普通用户权限
		$_POST['auth'] = 3;
		//用户名 密码 不能为空
		if (empty($_POST['uname']) || empty($upwd)) {
			$this -> error('用户名或密码不能为空');
		}

		//验证两次密码
		if ($_POST['reupwd'] !== $upwd) {
			$this -> error('两次密码输入不一致');
		}

		$_POST['upwd'] = password_hash($upwd, PASSWORD_DEFAULT);

		$user = M('bbs_user')->add($_POST);
		if ($user) {
			$_SESSION['userInfo'] = $_POST;
			$_SESSION['flag'] = true;
			$this -> success('注册成功', '/');
		} else {
			$this -> error('注册失败');
		}

	}

	public function doLogin()
	{
		$uname = $_POST['uname'];
		$upwd  = $_POST['upwd']; 
		//用户名 密码不能为空
		if (empty($_POST['uname']) || empty($_POST['upwd'])) {
			$this -> error('用户名和密码不能为空');
		}

		$user = M('bbs_user')->where("uname='$uname'")->find();
		// die;
		//验证密码
		if ($user && password_verify($upwd, $user['upwd'])) {
			$_SESSION['userInfo'] = $user;
			$_SESSION['flag'] = true;
			$this -> success('登陆成功', '/');
		} else {
			$this -> error('用户名和密码错误');
		}
	}

	public function logout()
	{
		$_SESSION['userInfo'] = null;
		$_SESSION['flag'] = false;

		$this -> success('退出成功', '/');
	}

}