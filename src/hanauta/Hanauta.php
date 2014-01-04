<?php
/**
 * Hanauta.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/05 last update
 * @copyright http://www.nono150.com/
 */


/**
 * Hanautaベースクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class Hanauta{
	var $version;
	var $obj;
	var $obj_ext;
	var $site_info;
	var $error;
	var $_srvars;
	var $_svars;
	var $_gvars;
	var $_cvars;
	var $_pvars;
	var $_fvars;
	var $carrier;
	var $script;

	/**
	 * コンストラクタ
	 */
	function __construct($dir_fw){

		// フレームワーク設定ファイル
		$dir_cnf = constant("DIR_CNF");
		$ini_fw = constant("INI_FW");
		$fw_arr = parse_ini_file($ini_fw);

		// 各クラス読み込み
		$this->obj = array();
		if($fw_arr["INI_LOAD"]){
			$load_arr = parse_ini_file($dir_cnf.$fw_arr["INI_LOAD"]);
			foreach($load_arr as $key => $value){
				require_once($dir_fw."/library/".$value.".php");
				$pos = mb_strpos($value, "/");
				if($pos !== false) $value = mb_substr($value,$pos+1);
				if($key == "read_db") $this->obj[$key] = new $key();
				else $this->obj[$key] = new $value();
			}
		}

		// プロジェクト設定ファイル
		$dir_sys = constant("DIR_SYS");
		$ini_sys = constant("INI_SYS");
		$sys_arr = parse_ini_file($ini_sys);

		// プロジェクト用拡張クラス読み込み
		$this->obj_ext = array();
		if(isset($sys_arr["INI_EXTEND"]) && $sys_arr["INI_EXTEND"]){
			$load_arr = parse_ini_file($sys_arr["INI_EXTEND"]);
			if(is_array($load_arr)){
				foreach($load_arr as $key => $value){
					include_once($dir_sys.$value.".php");
					$this->obj_ext[$key] = new $value();
				}
			}
		}

		// セッション開始
		session_start();
		// リクエスト変数設定
		// SERVER変数
		$this->_srvars = array();
		$this->_srvars = $this->obj["request"]->ser2vars();
		// SESSION変数
		$this->_svars = $this->obj["request"]->ses2vars();
		// GET変数
		$this->_gvars = $this->obj["request"]->get2vars();
		// COOKIE変数
		$this->_cvars = $this->obj["request"]->cookie2vars();
		// POST変数
		$this->_pvars = $this->obj["request"]->post2vars();
		// FILES変数
		$this->_fvars = $this->obj["request"]->file2vars();

		// プロジェクト用変数設定
		$this->site_info = array(
							// サイトタイトル
							"title" => $sys_arr["SITE_TITLE"],
							// サイトURL
							"url" => $sys_arr["SITE_URL"],
							// 文字コード
							"charset" => $sys_arr["SITE_CHARSET"],
							// タイムゾーン
							"time_zone" => $sys_arr["TIME_ZONE"] * 3600
		);

		// サーバー種類設定
		$this->site_info["server"] = "";
		print $dir_cnf;
		print "@";
		if(is_file($dir_cnf.$fw_arr["INI_SERVER"])){
			$server_arr = parse_ini_file($dir_cnf.$fw_arr["INI_SERVER"]);
			if(is_array($server_arr)){
				foreach($server_arr as $key => $value){
					if(isset($this->_srvars["HTTP_HOST"]) && $this->_srvars["HTTP_HOST"] == $value){
						$this->site_info["server"] = $key;
						break;
					}
				}
			}
		}
		if(empty($this->site_info["server"])){
			$server_arr = parse_ini_file($dir_fw."conf/server.ini");
			foreach($server_arr as $key => $value){
				if(isset($this->_srvars["HTTP_HOST"]) && $this->_srvars["HTTP_HOST"] == $value){
					$this->site_info["server"] = $key;
					break;
				}
			}
		}
		if(!empty($this->site_info["server"])){
			$this->site_info["server"] = strtolower($this->site_info["server"]);
			$srv_cnf_dir = $dir_cnf.$this->site_info["server"]."/";
		}else{
			$srv_cnf_dir = $dir_cnf;
		}

		// キャリア設定
		$this->carrier = $this->obj["mobile"]->get_carrier();

		// エラーコード設定
		// プロジェクト側にあればそちらを優先
		if(is_file($dir_cnf.$fw_arr["INI_ERROR"])) $error_ini = $dir_cnf.$fw_arr["INI_ERROR"];
		else $error_ini = $dir_fw."conf/error.ini";
		$error_arr = parse_ini_file($error_ini);
		$this->error = $error_arr;

		// フレームワークバージョン設定
		$ver_fw_arr = parse_ini_file($dir_fw."conf/version.ini");

		// スクリプトバージョン設定
		$ver_sys_arr = array();
		if(is_file($dir_cnf."version.ini")) $ver_sys_arr = parse_ini_file($dir_cnf."version.ini");
		$this->version = array_merge($ver_fw_arr,$ver_sys_arr);

		// タイムゾーン設定
		if(isset($sys_arr["TIME_ZONE_STR"])) ini_set("date.timezone",$sys_arr["TIME_ZONE_STR"]);

		// ヘッダー出力用変数
		define("CONTENT_TYPE_HTML","Content-Type: text/html; charset=".$this->site_info["charset"]);
		define("CONTENT_TYPE_XML","Content-Type: application/xml; charset=".$this->site_info["charset"]);

		// アクセス中のスクリプトファイルパスを取得
		$script = NULL;
		if(isset($this->_srvars["SCRIPT_NAME"])) $script = preg_replace("/\.php.*/",".php",$this->_srvars["SCRIPT_NAME"]);
		$script = preg_replace('/\/{2,}/','/',$script);
		if($script){
			$this->script["name"] = $script;
			$this->script["dir"] = dirname($script);
		}

		// DB接続
		if(is_file($srv_cnf_dir.$fw_arr["INI_DB"])){
			$connect = $this->obj["read_db"]->connect_db($srv_cnf_dir.$fw_arr["INI_DB"]);
			if(!$connect){
				header(constant("CONTENT_TYPE_HTML"));
				print $this->error["W0002"];
				exit;
			}
			$db_arr = parse_ini_file($srv_cnf_dir.$fw_arr["INI_DB"]);
			$this->site_info["db_prefix"] = $db_arr["DB_PREFIX"];
		}
	}

	/**
	 * 設定ファイル読み込み・定数化
	 *
	 * @access public
	 * @param string	$file	iniファイル名
	 */
	function read_ini($file){
		$ini = parse_ini_file($file);
		foreach($ini as $i_key => $i_val){
			define($key,$value);
		}
	}
}

?>
