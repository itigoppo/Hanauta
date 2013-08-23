<?php
class test{


	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	function test(){
		global $Hanauta;
		global $login_data;


		$last_id=false;
		$options = array("page"=>1,"include_rts"=>true,"include_entities"=>true);
		if($last_id && isset($user_options["last_rep"])) $options["since_id"] = $user_options["last_rep"];
		$tl_data = $Hanauta->obj["twitter"]->getMentions($login_data,$options);


		$Hanauta->obj["ponpon"]->pr($tl_data);
		//return $rtn;
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


	/**
	 * twitter 登録URL取得
	 * @return url
	 */
	function twitter(){
		global $Hanauta;

		$consumer = false;
		$token = array("auth_flg"=>false,"access_token"=>NULL,"access_token_secret"=>NULL);

		$consumer = $Hanauta->obj["twitter"]->twitter_auth($token);
		return $consumer;
	}
}