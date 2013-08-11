<?php
/**
 * len.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 長さチェック
 * 
 * @author HisatoS.
 * @access public
 * @package valiidate
 */

class len{
	/**
	 * コンストラクタ
	 */
	function len(){
	}
	
	/**
	 * チェック
	 * 
	 * @access public
	 * @param string	$str		文字列
	 * @param array		$param		パラメータ
	 * 						+bool	type	=> mbで計算時はtrue
	 * 						+int	min		=> 最小値
	 * 						+ibt	max		=> 最大値
	 * @return bool	true：正しい、false：不正
	 */
	function _check($str,$param=false){
		if(!isset($param["min"])) $param["min"] = 0;
		if(isset($param["type"]) && $param["type"]) $len = mb_strlen($str);
		else $len = strlen($str);
		if($param["min"] > $len || $param["max"] < $len) return false;
		return true;
	}
}

?>