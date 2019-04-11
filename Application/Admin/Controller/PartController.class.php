<?php
namespace Admin\Controller;

use Think\Controller;

class PartController extends Controller
{
	public function create()
	{
		$this -> display();
	}

	public function save()
	{
		$row = M('bbs_part')->add($_POST);
		if($row) {
			$this -> success('添加数据成功', '/index.php?m=admin&c=part&a=index');
		}else {
			$this -> error('添加数据失败');
		}
	}

	public function index()
	{
		$parts = M('bbs_part')->select();
		
		$this->assign('parts', $parts);
		$this->display();
	}

	public function edit()
	{
		$part = M('bbs_part')->find($_GET['pid']);
		$this -> assign('part', $part);
		$this -> display();
	}

	public function update()
	{
		$pid = $_GET['pid'];
		$row = M('bbs_part')->where("pid=$pid")->save($_POST);
		if($row) {
			$this -> success('修改数据成功', '/index.php?m=admin&c=part&a=index');
		} else {
			$this -> error('修改数据失败');
		}
	}

	public function del()
	{
		$pid = $_GET['pid'];
		$row = M('bbs_part')->where("pid=$pid")->delete();
		if($row) {
			$this -> success('删除数据成功', '/index.php?m=admin&c=part&a=index');
		}else {
			$this -> error('删除数据失败');
		}
	}
}