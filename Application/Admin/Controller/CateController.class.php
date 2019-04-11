<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends Controller
{
	public function create()
	{
		$users = M('bbs_user')->select(); 
		$pids  = M('bbs_part')->select();

		$this -> assign('users', $users);
		$this -> assign('pids', $pids);
		$this -> display();
	}

	public function save()
	{
		$row = M('bbs_cate')->add($_POST);
		if($row) {
			$this -> success('添加数据成功', '/index.php?m=admin&c=cate&a=index');
		} else {
			$this -> error('添加数据失败');
		}
	}

	public function index()
	{
		$cates = M('bbs_cate')->select();
		// $parts = M('bbs_part')->select();
		// $users = M('bbs_user')->select();


		// $parts = array_column($parts, 'pname', 'pid');
		// $users = array_column($users, 'uname', 'uid');

		$parts = M('bbs_part')->getField('pid, pname');
		$users = M('bbs_user')->getField('uid, uname');

		// echo '<pre>';
		// var_dump($parts, $users);
		// die;
		
		$this -> assign('cates', $cates);
		$this -> assign('parts', $parts);
		$this -> assign('users', $users);
		$this -> display();
	}

	public function edit()
	{
		$cid   = $_GET['cid'];
		$parts = M('bbs_part')->select();
		$cate  = M('bbs_cate')->where("cid=$cid")->find();
		$users = M('bbs_user')->select();
		
		$this -> assign('users', $users);
		$this -> assign('parts', $parts);
		$this -> assign('cate', $cate);
		$this -> display();
	}

	public function update()
	{
		$cid = $_GET['cid'];
		$row = M('bbs_cate')->where("cid=$cid")->save($_POST);
		if ($row) {
			$this -> success('修改数据成功');
		} else {
			$this -> error('修改数据失败');
		}
	}

	public function del()
	{
		$cid = $_GET['cid'];
		$row = M('bbs_cate')->delete($cid);
		if ($row) {
			$this -> success('删除数据成功');
		} else {
			$this -> error('删除数据失败');
		}
	}
}