<?php
/**
 * noempty.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 空白チェック
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class noempty{
	/**
	 * コンストラクタ
	 */
	function noempty(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		$str = trim($str);
		if(!isset($str)) return false;
		if($str === false) return false;
		if($str == NULL) return false;
		return true;
	}
}

?>