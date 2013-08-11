<?php
/**
 * han_int.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 半角数字チェック（マイナス可）
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class han_int{
	/**
	 * コンストラクタ
	 */
	function han_int(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		$pattern = "/^-?[0-9]+$/";
		if(!preg_match($pattern,$str)) return false;
		return true;
	}
}

?>