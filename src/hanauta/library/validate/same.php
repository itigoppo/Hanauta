<?php
/**
 * same.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 同値チェック
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class same{
	/**
	 * コンストラクタ
	 */
	function same(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @param array		$param		パラメータ
	 * 						+string	word	=> 比べる文字列
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		if($param["word"] !== $str) return false;
		return true;
	}
}

?>