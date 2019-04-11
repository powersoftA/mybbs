<?php
namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
	public function login()
	{
		$this -> display();
	}

	public function doLogin()
	{
		$uname = $_POST['uname'];
		$upwd  = $_POST['upwd']; 
		$code  = $_POST['code'];

		if (empty($code)) {
			$this -> error('验证码不能为空');
		}
		$verify = new \Think\Verify();
		//验证码处理
		if (!$verify->check($code, $id)){
			$this -> error('验证码输入不正确');
		}
		//用户名和密码不能为空
		if (empty($uname) || empty($upwd)) {
			$this -> error('用户名或密码不能为空');
		}
		//验证密码
		$user = M('bbs_user')->where("uname='$uname'")->find();
		if ($user && password_verify($upwd, $user['upwd'])) {
			$_SESSION['userInfo'] = $user;
			$_SESSION['flag'] = true;
			$this -> success('登录成功', '/index.php?m=admin&c=index&a=index');
		} else {
			$this -> error('用户名或密码不正确', '/index.php?m=admin&c=login&a=login');
		}
	}

	public function logout()
	{
		$_SESSION['userInfo'] = null;
		$_SESSION['flag'] = false;

		$this -> success('退出成功', '/index.php?m=admin&c=login&a=login');
	}

	public function code()
	{
		$config = array(
		'fontSize' => 15, // 验证码字体大小
		'length' => 3, // 验证码位数
		'useNoise' => false, // 关闭验证码杂点
		);
		$Verify = new \Think\Verify($config);
		$Verify->entry();
	}
}