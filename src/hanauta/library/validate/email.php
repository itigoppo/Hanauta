<?php
/**
 * email.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/08/24 last update
 * @copyright http://www.nono150.com/
 */

/**
 * メールアドレスチェック
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class email{
	/**
	 * コンストラクタ
	 */
	function email(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		$pattern = "/^[a-zA-Z0-9\"\._\?\+\/-]+\@[a-zA-Z0-9\-_]+.[a-zA-Z0-9\-_.]+$/";
		$pattern = "/\\A(?:^([a-z0-9][a-z0-9_\\-\\.\\+]*)@([a-z0-9][a-z0-9\\.\\-]{0,63}\\.(com|org|net|biz|info|name|net|pro|aero|coop|museum|[a-z]{2,4}))$)\\z/i";
		if(!preg_match($pattern,$str)) return false;
		return true;
	}
}

?>