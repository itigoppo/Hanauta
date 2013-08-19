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


		$tbl_name = $Hanauta->site_info["db_prefix"]."user";
		$fld_name = NULL;
		$where = NULL;
		$db_param = array();
		$db_rtn = $Hanauta->obj["read_db"]->select_db($tbl_name,$fld_name,$where,$db_param);

/*
		for($cnt1=0; $cnt1<$Hanauta->obj["read_db"]->get_result($db_rtn,"rows"); $cnt1++){
			$user_data = $Hanauta->obj["string"]->encode_str($Hanauta->obj["read_db"]->get_result($db_rtn,"assoc"));
			$Hanauta->obj["ponpon"]->pr($user_data);
		}
*/



		$Hanauta->obj["ponpon"]->pr(get_defined_constants());


		$Hanauta->obj["ponpon"]->pr($Hanauta);

		/*
		global $fw_ini_db;

		$Hanauta->obj["ponpon"]->pr($fw_ini_db);
		$this->obj["ponpon"]->pr($this->obj);
		$this->obj["ponpon"]->pr($this->obj_ext);
		*/
	}
}