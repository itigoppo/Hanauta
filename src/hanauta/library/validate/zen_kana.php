<?php
/**
 * zen_kana.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 半角英字チェック
 *
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class zen_kana extends string{
	/**
	 * コンストラクタ
	 */
	function zen_kana(){
		$this->string();
	}

	/**
	 * チェック
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param array		$param		パラメータ
	 * 						+bool	space	=> スペース許可
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		$str = $this->convart_charset($str,"UTF-8");
		//$pattern = "/^(\xe3(\x82|\x83)[\x81-\xbf])+$/";
		//$pattern = "/^(\xe3(\x82|\x83)[\x80-\xbf])+$/";
		$pattern = "/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6]|[0-9a-zA-Z])+$/";
		if(isset($param["space"]) && $param["space"]) $pattern = "/^(?:\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6]|[0-9a-zA-Z]|[ 　])+$/";
		if(!preg_match($pattern,$str)) return false;
		return true;
	}
}

?>