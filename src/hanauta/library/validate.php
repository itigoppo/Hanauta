<?php
/**
 * validate.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/02/07 last update
 * @copyright http://www.nono150.com/
 */

/**
 * エラーチェッククラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class validate{
	/**
	 * コンストラクタ
	 */
	function __construct(){
		$dir_fw = constant("DIR_FW");
		$dir_val = $dir_fw."/library/validate/";

		if($handle = opendir("$dir_val")){
			while(false !== ($item = readdir($handle))){
				if($item != "." && $item != ".." && $item != ".svn"){
					$file_info = pathinfo($dir_val.$item);
					include_once($dir_val.$item);
					$this->validate[$file_info["filename"]] = new $file_info["filename"]();
				}
			}
		}
	}

	/**
	 * エラーチェック
	 *
	 * @access public
	 * @param array		$str_arr	エラーチェックルール
	 * @return array	チェック結果
	 */
	function error_msg($str_arr){
		$request = new request();

		$rtn = NULL;
		$rtn_arr = array("error"=>false);
		$_pvars = $request->post2vars();
		$_gvars = $request->get2vars();

		foreach($str_arr as $key => $val){
			if(isset($_gvars[$key])) $data = $_gvars[$key];
			elseif(isset($_pvars[$key])) $data = $_pvars[$key];
			else $data = NULL;
			$rtn_arr[$key] = false;
			foreach($val as $v_key => $v_val){
				if(isset($v_val["param"])) $param = $v_val["param"];
				else $param = false;
				if(!$this->validate[$v_val["rule"]]->_check($data,$param)){
					$rtn_arr["error"] = true;
					if(isset($param["min"])) $v_val["msg"] = mb_ereg_replace("##MIN##",$param["min"],$v_val["msg"]);
					else $v_val["msg"] = mb_ereg_replace("##MIN##",0,$v_val["msg"]);
					if(isset($param["max"])) $v_val["msg"] = mb_ereg_replace("##MAX##",$param["max"],$v_val["msg"]);
					if(isset($v_val["msg"])) $rtn_arr[$key] = $v_val["msg"];
					else $rtn_arr[$key] = true;
				}
			}

		}

		$rtn = $rtn_arr;

		return $rtn;
	}
}
?>