<?php
	function getSm($fileName)
	{
		$sm_uface = explode('/', $fileName);
	    $sm_uface[3] = 'sm_' . $sm_uface[3];
	    return $sm_ext = implode('/', $sm_uface);
	}