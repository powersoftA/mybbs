<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {
    	$parts = M('bbs_part')->select();
    	$parts = array_column($parts, null, 'pid');
    	$cates = M('bbs_cate')->select();
    	foreach ($cates as $cate) {
    		$parts[$cate['pid']]['sub'][] = $cate;
    	}

    	$this -> assign('cates', $cates);
    	$this -> assign('parts', $parts);
        $this->display();
    }
}