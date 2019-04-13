<?php
namespace Home\Controller;

use Think\Controller;

class PostController extends Controller
{
	public function create()
	{
		//判断用户是否登陆
		if (empty($_SESSION['flag'])) {
			$this -> error('您还未登陆,请先登录');
		}
		$cates = M('bbs_cate')->select();
		$this -> assign('cates', $cates);
		$this -> display();
	}

	public function save()
	{
		$_POST['uid'] = $_SESSION['userInfo']['uid'];
		$_POST['created_at'] = time();
		$cid = $_POST['cid'];
		//标题不能为空
		if (empty($_POST['title'])) {
			$this -> error('标题不能为空');
		}
		$row = M('bbs_post')->where("uid='$uid'")->add($_POST);
		if ($row) {
			$this -> success('发帖成功', "/index.php?m=home&c=post&a=index&cid=$cid");
		} else {
			$this -> error('发帖失败');
		}
	}

	public function index()
	{
		$cid = $_GET['cid'];
		$posts = M('bbs_post')->where("cid='$cid'")->order('created_at desc')->select();
		$users = M('bbs_user')->getField('uid,uname');

		// echo '<pre>';
		// print_r($posts);
		// die;
		$this -> assign('users', $users);
		$this -> assign('posts', $posts);
		$this -> display();
	}
}