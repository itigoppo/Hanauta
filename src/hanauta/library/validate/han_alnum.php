<?php
/**
 * han_alnum.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 半角英数字チェック
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class han_alnum{
	/**
	 * コンストラクタ
	 */
	function han_alnum(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		$pattern = "/^[0-9a-zA-Z]+$/";
		if(!preg_match($pattern,$str)) return false;
		return true;
	}
}

?>