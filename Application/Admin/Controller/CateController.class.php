<?php
namespace Admin\Controller;

use Think\Controller;

class CateController extends Controller
{
	public function create()
	{
		$pids = M('bbs_part')->select();
		$this->assign('pids', $pids);
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

	}

	public function update()
	{

	}

	public function del()
	{

	}
}