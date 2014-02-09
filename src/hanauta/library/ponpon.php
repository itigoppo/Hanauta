<?php
/**
 * hanauta.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 13/06/14 last update
 * @copyright http://www.nono150.com/
 */

/**
 * あれこれ詰め合わせクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class ponpon{
	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * pre debug
	 *
	 * @access public
	 * @param string	$str		文字列or配列
	 * @return string	<pre>$str</pre><hr />
	 */
	function pr($str){
		print "<pre>";
		print_r($str);
		print "</pre><hr />";
	}
}

?>