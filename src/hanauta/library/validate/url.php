<?php
/**
 * url.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * URLチェック
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class url{
	/**
	 * コンストラクタ
	 */
	function url(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		$pattern = "/^https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+$/";
		if(!preg_match($pattern,$str)) return false;
		return true;
	}
}

?>