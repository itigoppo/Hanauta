<?php
/**
 * request.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 07/06/25 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 汎用受け取り関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class request extends string{
	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->string();
	}

	/**
	 * $_SERVER->VALUE
	 *
	 * @access public
	 * @return array	$_SERVERデータ
	 */
	function ser2vars(){
		$rtn = array();

		if(phpversion() >= "4.1.0"){
			if(isset($_SERVER)) $rtn = $_SERVER;
		}else{
			if(isset($HTTP_SERVER_VARS)) $rtn = $HTTP_SERVER_VARS;
		}

		return $rtn;
	}

	/**
	 * $_GET->VALUE
	 *
	 * @access public
	 * @return array	$_GETデータ
	 */
	function get2vars(){
		$rtn = array();

		if(phpversion() >= "4.1.0"){
			if(isset($_GET)) $rtn = $_GET;
		}else{
			if(isset($HTTP_GET_VARS)) $rtn = $HTTP_GET_VARS;
		}
		$rtn = $this->decode_url($rtn);

		return $rtn;
	}

	/**
	 * $_POST->VALUE
	 *
	 * @access public
	 * @return array	$_POSTデータ
	 */
	function post2vars(){
		$rtn = array();

		if(phpversion() >= "4.1.0"){
			if(isset($_POST)) $rtn = $_POST;
		}else{
			if(isset($HTTP_POST_VARS)) $rtn = $HTTP_POST_VARS;
		}

		return $rtn;
	}

	/**
	 * $_COOKIE->VALUE
	 *
	 * @access public
	 * @return array	$_COOKIEデータ
	 */
	function cookie2vars(){
		$rtn = array();

		if(phpversion() >= "4.1.0"){
			if(isset($_COOKIE)) $rtn = $_COOKIE;
		}else{
			if(isset($HTTP_COOKIE_VARS)) $rtn = $HTTP_COOKIE_VARS;
		}

		return $rtn;
	}

	/**
	 * $_FILES->VALUE
	 *
	 * @access public
	 * @return array	$_FILESデータ
	 */
	function file2vars(){
		$rtn = array();

		if(phpversion() >= "4.1.0"){
			if(isset($_FILES)) $rtn = $_FILES;
		}else{
			if(isset($HTTP_POST_FILES)) $rtn = $HTTP_POST_FILES;
		}

		return $rtn;
	}

	/**
	 * $_SESSION->VALUE
	 *
	 * @access public
	 * @return array	$_SESSIONデータ
	 */
	function ses2vars(){
		$rtn = array();

		if(phpversion() >= "4.1.0"){
			if(isset($_SESSION)) $rtn = $_SESSION;
		}else{
			if(isset($HTTP_SESSION_VARS)) $rtn = $HTTP_SESSION_VARS;
		}

		return $rtn;
	}

	/**
	 * VALUE->$_SESSION
	 *
	 * @access public
	 * @param string	$key		格納キー
	 * @param string	$rtn		格納データ
	 */
	function vars2ses($key,$rtn){

		if(phpversion() >= "4.1.0"){
			if(isset($_SESSION[$key])) unset($_SESSION[$key]);
			$_SESSION[$key] = $rtn;
		}else{
			if(isset($HTTP_SESSION_VARS[$key])) unset($HTTP_SESSION_VARS[$key]);
			$HTTP_SESSION_VARS[$key] = $rtn;
		}
	}

	/**
	 * $_SESSION削除
	 *
	 * @access public
	 * @param array		$data_arr	データ
	 * @param array		$key_arr	例外キー
	 */
	function del_ses($data_arr,$key_arr=NULL){
		foreach($data_arr as $key => $val){
			if(is_array($key_arr) && isset($key_arr[0])){
				foreach($key_arr as $key2 => $val2){
					if($key == $val2) continue 2;
				}
			}
			$this->vars2ses($key, array());
			unset($key);
		}
	}
}

?>
