<?php
class test{


	/**
	 * コンストラクタ
	 */
	function __construct(){
	}


	function twitter(){
		global $Hanauta;


	}

	function test(){
		global $Hanauta;

		$rtn = array();
		$consumer = NULL;
		$token = array("auth_flg"=>false,"access_token"=>NULL,"access_token_secret"=>NULL);
		$auth_data = array("db"=>false,"user"=>array());
		$save_flg = false;
		$now_date = gmdate("Y-m-d H:i:s",time() + $Hanauta->site_info["time_zone"]);

		// DBからトークン取得
		$token = false;
		if(isset($Hanauta->site_info["db_prefix"])){

			$Hanauta->_pvars["submit"] = "1";
			$Hanauta->_pvars["login_id"] = "api";
			$Hanauta->_pvars["login_pass"] = "1333";

			$auth_data = $this->auth();
			if(isset($auth_data["user"]["token"]) && isset($auth_data["user"]["token_secret"])){
				$token = array(
								"auth_flg" => true,
								"access_token" => $auth_data["user"]["token"],
								"access_token_secret" => $auth_data["user"]["token_secret"]
							);
			}
		}
		// session内トークン確認
		if(isset($Hanauta->_svars["token"]["access_token"]) && isset($Hanauta->_svars["token"]["access_token_secret"])){
			if(isset($Hanauta->_svars["token"]["flg"]) && $Hanauta->_svars["token"]["flg"] == "callback"){
				$token = array(
								"auth_flg" => true,
								"access_token" => $Hanauta->_svars["token"]["access_token"],
								"access_token_secret" => $Hanauta->_svars["token"]["access_token_secret"]
							);
			}
		}
		$consumer = $Hanauta->obj["twitter"]->twitter_auth($token);
		$Hanauta->obj["ponpon"]->pr($consumer);


		$Hanauta->obj["ponpon"]->pr($Hanauta);
	}



	function auth(){
		global $Hanauta;

		$rtn = false;
		$auth = array();
		$auth_flg = false;
		$mode = false;
		if(isset($Hanauta->_gvars["login_id"])) $login_id = $Hanauta->_gvars["login_id"];
		elseif(isset($Hanauta->_pvars["login_id"])) $login_id = $Hanauta->_pvars["login_id"];
		else $login_id = false;
		$uid = $Hanauta->obj["mobile"]->get_uid();

		// 情報読み出し
		$tbl_name = $Hanauta->site_info["db_prefix"]."user";
		$fld_name = NULL;

		if(isset($Hanauta->_svars["auth"]["key"])){
			// 認証済み
			$mode = "auth";
			$where = NULL;
			$db_param = array();
		}elseif(isset($Hanauta->_pvars["submit"]) || isset($Hanauta->_pvars["Submit"]) || ($uid && $login_id)){
			// ログイン
			$mode = "login";
			$where = "id='".$login_id."'";
			$db_param = array(
							"limit"		=> 1
							);
		}
		if($mode) $db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param,true);
		else $db_rtn = false;

		// 一致ID検索
		$rtn_arr = array();
		if(!$db_rtn){
			$rtn_arr["db"] = false;
		}else{
			$rtn_arr["db"] = true;
			$user_data = array();
			for($cnt1=0; $cnt1<$Hanauta->obj["read_db"]->get_result($db_rtn,"rows"); $cnt1++){
				$user_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
				if($mode == "auth"){
					// 認証チェック
					if(isset($Hanauta->_svars["auth"]["type"]) && $Hanauta->_svars["auth"]["type"] == "uid"){
						$key = md5($user_data["id"].$user_data["uid"].$user_data["salt"]);
					}else if(isset($Hanauta->_svars["auth"]["type"]) && $Hanauta->_svars["auth"]["type"] == "pass"){
						$key = md5($user_data["id"].$user_data["pass"].$user_data["salt"]);
					}else{
						$key = NULL;
					}
					if($Hanauta->_svars["auth"]["key"] == $key){
						$auth_flg = true;
						break;
					}
				}else if($mode == "login"){
					// ログインチェック
					if(!isset($Hanauta->_pvars["login_pass"]) && $uid){
						if($user_data["uid"] == $uid){
							$auth_flg = true;
							$key = md5($user_data["id"].$user_data["uid"].$user_data["salt"]);
							$auth = array("type"=>"uid","key"=>$key);
							break;
						}
					}else if(isset($Hanauta->_pvars["login_pass"])){
						if($user_data["pass"] == $Hanauta->_pvars["login_pass"]){
							$auth_flg = true;
							$key = md5($user_data["id"].$user_data["pass"].$user_data["salt"]);
							$auth = array("type"=>"pass","key"=>$key);
							break;
						}
					}
				}
			}
		}

		if($auth_flg){
			if($mode == "login") $Hanauta->obj["request"]->vars2ses("auth",$auth);
			$rtn_arr["user"] = $user_data;
		}else{
			$rtn_arr["user"] = false;
		}
		$rtn = $rtn_arr;

		return $rtn;
	}

	/**
	 * DB selectテスト
	 */
	function db_test(){
		global $Hanauta;

		$tbl_name = $Hanauta->site_info["db_prefix"]."user";
		$fld_name = NULL;
		$where = NULL;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param,true);

		for($cnt1=0; $cnt1<$Hanauta->obj["read_db"]->get_result($db_rtn,"rows"); $cnt1++){
			$user_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
			$Hanauta->obj["ponpon"]->pr($user_data);
		}
	}
}