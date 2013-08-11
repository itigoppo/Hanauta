<?php
/**
 * Hanauta.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/05 last update
 * @copyright http://www.nono150.com/
 */

// フレームワーク設定ファイル
$dir_cnf = constant("DIR_CNF");
$ini_fw = constant("INI_FW");
$fw_arr = parse_ini_file($ini_fw);

// 各クラス読み込み
$obj = array();
if($fw_arr["INI_LOAD"]){
	$load_arr = parse_ini_file($dir_cnf.$fw_arr["INI_LOAD"]);
	foreach($load_arr as $key => $value){
		require_once($dir_fw."/library/".$value.".php");
		$pos = mb_strpos($value, "/");
		if($pos !== false) $value = mb_substr($value,$pos+1);
		if($key == "read_db") $obj[$key] = new $key();
		else $obj[$key] = new $value();
	}
}

// プロジェクト設定ファイル
$dir_sys = constant("DIR_SYS");
$ini_sys = constant("INI_SYS");
$sys_arr = parse_ini_file($ini_sys);

// プロジェクト用拡張クラス読み込み
$obj_ext = array();
if(isset($sys_arr["INI_EXTEND"]) && $sys_arr["INI_EXTEND"]){
	$load_arr = parse_ini_file($sys_arr["INI_EXTEND"]);
	if(is_array($load_arr)){
		foreach($load_arr as $key => $value){
			include_once($dir_sys.$value.".php");
			$obj_ext[$key] = new $value();
		}
	}
}

// セッション開始
session_start();
// リクエスト変数設定
// SERVER変数
$_srvars = array();
$_srvars = $obj["request"]->ser2vars();
// SESSION変数
$_svars = $obj["request"]->ses2vars();
// GET変数
$_gvars = $obj["request"]->get2vars();
// COOKIE変数
$_cvars = $obj["request"]->cookie2vars();
// POST変数
$_pvars = $obj["request"]->post2vars();
// FILES変数
$_fvars = $obj["request"]->file2vars();


/**
 * DB接続
 * 
 */

if(is_file($dir_cnf.$fw_arr["INI_DB"])) $obj["read_db"]->connect_db($dir_cnf.$fw_arr["INI_DB"]);

/**
 * Hanautaベースクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class Hanauta{
	/**
	 * コンストラクタ
	 */
	function Hanauta(){
		// スクリプトファイルパスを取得
		$script = NULL;
		if(isset($_SERVER["SCRIPT_NAME"])) $script = preg_replace("/\.php.*/",".php",$_SERVER["SCRIPT_NAME"]);
		$script = preg_replace('/\/{2,}/','/',$script);
		if($script){
			define("SCRIPT_NAME",$script);
			define("SCRIPT_DIR",dirname($script));
		}
		
		// ローカルサーバーか否か
		$localhost = false;
		if(isset($_SERVER["SERVER_ADDR"]) && $_SERVER["SERVER_ADDR"] == "127.0.0.1") $localhost = true;
		define("LOCALHOST",$localhost);
		
		// エラーコード設定
		$dir_fw = constant("DIR_FW");
		$dir_cnf = constant("DIR_CNF");
		$ini_fw = constant("INI_FW");
		$fw_arr = parse_ini_file($ini_fw);
		// プロジェクト側にあればそちらを優先
		if(is_file($dir_cnf.$fw_arr["INI_ERROR"])) $this->read_ini($dir_cnf.$fw_arr["INI_ERROR"]);
		else $this->read_ini($dir_fw."conf/error.ini");
		
		// フレームワークバージョン設定
		$this->read_ini($dir_fw."conf/version.ini");
		
		// スクリプトバージョン設定
		if(is_file($dir_cnf."version.ini")) $this->read_ini($dir_cnf."version.ini");
	}

	/**
	 * 設定ファイル読み込み・定数化
	 *
	 * @access public
	 * @param string	$file	iniファイル名
	 */
	function read_ini($file){
		$ini = parse_ini_file($file);
		foreach($ini as $key => $value){
			define($key,$value);
		}
	}
}

?>
