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
		// リプライ
		$options = array("count"=>20,"trim_user"=>false,"contributor_details"=>false,"include_entities"=>false);
		//if($last_id && isset($user_options["last_rep"])) $options["since_id"] = $user_options["last_rep"];
		//$tl_data = $Hanauta->obj["twitter"]->getMentions($login_data,$options);

		// ユーザーTL
		$options = array("count"=>20,"trim_user"=>false,"exclude_replies"=>false,"contributor_details"=>false,"include_rts"=>true);
		//$tl_data = $Hanauta->obj["twitter"]->getUserTimeline($login_data,$options);


		// ホームTL
		$options = array("count"=>30,"trim_user"=>false,"exclude_replies"=>false,"contributor_details"=>false,"include_rts"=>true);
		$tl_data = $Hanauta->obj["twitter"]->getHomeTimeline($login_data,$options);


		/*
		 * since_id,max_id,count,trim_user,exclude_replies,contributor_details,include_entities
		 *
		 *
		 * user_id : ユーザーID
		 * screen_name : スクリーンネーム
		 *
		 * since_id : (int) 指定ポストIDより新しいポストを取得
		 * max_id : (int) 指定ポストIDより古いポストを取得
		 * count : 取得件数（最大200件）
		 * trim_user : (bool:false) ユーザー情報をIDだけにするか否か
		 * exclude_replies : (bool:false) リプライを取得するか否か
		 * contributor_details : (bool:false) 貢献者情報を表示
		 * include_entities : (bool:false) エントリー情報を表示
		 *
		 * include_rts : (bool:false) RTを取得するか否かを表示
		 *
		 * ,since_id,max_id,trim_user,contributor_details,include_entities
		 *
		 *
		 */


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