﻿<?php
	
	/**
 * 静态化
 *
 * @package htmlfunction
 * @author  Mr Yang
 */


    class htmlcms {

	private $html_path = 'data/html/'; //静态页面目录
	private $key; //生成的HTML静态页面对应的KEY值
	private $ismd5 = false; //生成的文件名是否MD5加密
	
	/**
	 *	静态页面-开启ob_start(),打开缓冲区
	 *  @return 
	 */
	public function start() {
		return ob_start();
	}
	
	/**
	 *	静态页面-生成静态页面，$key值是生成页面的唯一标识符
	 * 	@param  string  $key  静态页面标识符，可以用id代替
	 *  @return 
	 */
	public function end($key) {
		$this->key = $key;
		$this->html(); //生成HTML文件
		return ob_end_clean(); //清空缓冲
	}
	
	/**
	 *	静态页面-获取静态页面
	 * 	@param  string  $key  静态页面标识符，可以用id代替
	 *  @return 
	 */
	public function get($key) {
		$filename = $this->get_filename($key);
		if (!$filename || !file_exists($filename)) return false;
		include($filename);
		return true;
	}
	
	/**
	 *	静态页面-生成静态页面
	 *  @return 
	 */
	private function html() {
		$filename = $this->get_filename($this->key);
		if (!$filename) return false;
		return @file_put_contents($filename, ob_get_contents());
	}
	
	/**
	 *	静态页面-静态页面文件
	 *  @return 
	 */
	private function get_filename($key) {
		$filename = ($this->ismd5 == true) ? md5($key) : $key;
		if (!is_dir($this->html_path)) return false;
		return $this->html_path . '/' . $filename . '.htm';
	}
}
?>