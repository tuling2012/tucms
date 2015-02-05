<?php
/**
 * 目录函数
 *
 * @package dirfunction
 * @author  tling
 */

/**
 * 转\为/ ,确保路径最后有/
 */
function dir_path($path) {
	$path = str_replace('\\', '/', $path);
	if(substr($path,-1) != '/') {
		$path .= '/';
	}
	return $path;	
}

/**
 * 创建目录
 */
function dir_create($path, $mode = 0777) {
	if(is_dir($path)) return true;
	$path = dir_path($path);
	$temp = explode('/', $path);
	$cur_dir = '';
	$max = count($temp) - 1;
	for($i=0;$i<$max;$i++) {
		$cur_dir .= $temp[$i].'/';
		if(@is_dir($cur_dir)) {
			continue;
		}
		@mkdir($cur_dir, $mode, true);
		@chmod($cur_dir, $mode);
	}
	return is_dir($path);	
}

/**
 * 改进版
 */
function dir_create_2($path, $mode) {
	if(is_dir($path)) {
		return true;
	}
	$path = dir_path($path);
	$temp = explode('/', $path);
	$cur_dir = '';
	foreach($temp as $v) {
		$cur_dir .= $v.'/';
		if(is_dir($cur_dir)) {
			continue;
		} else {
			@mkdir($cur_dir);
			chmod($cur_dir, $mode);
		}
	}
	
}

/**
 * 拷贝目录下所有文件
 */
function dir_copy($fromdir, $todir) {
	$fromdir = dir_path($fromdir);
	$todir = dir_path($todir);
	if(!is_dir($fromdir)) {
		return false;
	} 
	if(!is_dir($todir)) {
		dir_create($todir);
	}
	
	$list = glob($fromdir.'*');
	print_r($list);
	if(empty($list)) {
		return true;
	}
	
	foreach($list as $v) {
		$path = $todir.basename($v);
		if(is_dir($v)) {
			dir_copy($v, $path);
		} else {
			copy($v,$path);
			@chmod($path, 0777);
		}
	}
	return true;
}

/**
 * 删除目录及目录下的所有文件
 */
function dir_delete($dir) {
	$dir = dir_path($dir);
	if(!is_dir($dir)) {
		return false;
	}
	$list = glob($dir.'*');
	foreach($list as $v) {
		is_dir($v) ? dir_delete($v) : @unlink($v);
	}
	return @rmdir($dir);
	
}

/**
 * 列出目录下所有文件
 */
function dir_list($path, $exts = '', $list = array()) {
	$path = dir_path($path);
	$files = glob($path.'*');
	foreach($files as $v) {
		if(!$exts || pathinfo($v,PATHINFO_EXTENSION) == $exts) {
			$list[] = $v;			
		}
		if(is_dir($v)) {
			$list = dir_list($v, $exts, $list);
		}
	}
	return $list;	
}


?>