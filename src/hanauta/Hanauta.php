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
	var $obj;
	var $obj_ext;
	var $_srvars;
	var $_svars;
	var $_gvars;
	var $_cvars;
	var $_pvars;
	var $_fvars;
	var $server;
	var $carrier;
	var $db_prefix;

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

		// サーバー種類設定
		$this->server = "";
		if(is_file($dir_cnf.$fw_arr["INI_SERVER"])){
			$server_arr = parse_ini_file($dir_cnf.$fw_arr["INI_SERVER"]);
			if(is_array($server_arr)){
				foreach($server_arr as $key => $value){
					if(isset($this->_srvars["HTTP_HOST"]) && $this->_srvars["HTTP_HOST"] == $value){
						$this->server = $key;
						break;
					}
				}
			}
		}
		if(empty($this->server)){
			$server_arr = parse_ini_file($dir_fw."conf/server.ini");
			foreach($server_arr as $key => $value){
				if(isset($this->_srvars["HTTP_HOST"]) && $this->_srvars["HTTP_HOST"] == $value){
					$this->server = $key;
					break;
				}
			}
		}
		if(!empty($this->server)){
			$this->server = strtolower($this->server);
			$srv_cnf_dir = $dir_cnf.$this->server."/";
		}else{
			$srv_cnf_dir = $dir_cnf;
		}

		/**
		 * DB接続
		 *
		 */
		if(is_file($srv_cnf_dir.$fw_arr["INI_DB"])){
			$this->obj["read_db"]->connect_db($srv_cnf_dir.$fw_arr["INI_DB"]);
			$db_arr = parse_ini_file($srv_cnf_dir.$fw_arr["INI_DB"]);
			$this->db_prefix = $db_arr["DB_PREFIX"];
		}

		// スクリプトファイルパスを取得
		$script = NULL;
		if(isset($_SERVER["SCRIPT_NAME"])) $script = preg_replace("/\.php.*/",".php",$_SERVER["SCRIPT_NAME"]);
		$script = preg_replace('/\/{2,}/','/',$script);
		if($script){
			define("SCRIPT_NAME",$script);
			define("SCRIPT_DIR",dirname($script));
		}

		// キャリア設定
		$this->carrier = $this->obj["mobile"]->get_carrier();

		// エラーコード設定
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
