<?php
class test{
	/**
	 * コンストラクタ
	 */
	function __construct(){
		global $obj,$obj_ext;
		$this->obj = $obj;
		$this->obj_ext = $obj_ext;
	}


	function test(){
		global $fw_ini_db;

		$this->obj["ponpon"]->pr($fw_ini_db);
		$this->obj["ponpon"]->pr($this->obj);
		$this->obj["ponpon"]->pr($this->obj_ext);
	}
}