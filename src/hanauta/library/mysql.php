<?php
/**
 * mysql.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 13/08/20 last update
 * @copyright http://www.nono150.com/
 */

/**
 * MySQL取扱クラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class read_db{

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * DB接続
	 *
	 * @access public
	 * @param string	$ini_db		DB設定ファイル
	 * @return bool	true：接続成功時、false：解除失敗時
	 */
	function connect_db($ini_db){
		if(defined("CONNECT")) return;
		$ini_arr = parse_ini_file($ini_db);
		$server = $ini_arr["DB_SERVER"];
		$user = $ini_arr["DB_USER"];
		$pass = $ini_arr["DB_PASS"];
		$db_name = $ini_arr["DB_NAME"];

		$connect = @mysql_connect($server,$user,$pass);
		if(!$connect) return false;
		if(!@mysql_select_db($db_name)) return false;
		@mysql_set_charset($ini_arr["DB_CHARSET"]);
		define("CONNECT",$connect);
		return true;
	}

	/**
	 * DB解除
	 *
	 * @access public
	 * @return bool	true：接続成功時、false：解除失敗時
	 */
	function closed_db(){
		$connect = constant("CONNECT");
		if(!@mysql_close($connect)) return false;
		return true;
	}

	/**
	 * SQL実行
	 *
	 * @access public
	 * @param string	$sql		SQL
	 * @param int		$mode		SELECT文以外(INSERT、UPDATE、DELETE
	 * @param int		$debug_flg	デバッグ表示フラグ(0:未使用、1:表示
	 * @return string	SQLの結果
	 */
	function send_query($sql,$mode=0,$debug_flg=false){
		$connect = constant("CONNECT");
		if($debug_flg) print "<pre>".$sql."</pre>\n";
		$rtn = @mysql_query($sql,$connect);
		if($mode == 0){
			if(!$this->get_result($rtn,"rows")) return false;
		}
		return $rtn;
	}

	/**
	 * 結果を取得
	 *
	 * @access public
	 * @param string	$result		実行結果
	 * @param string	$mode		結果タイプ
	 *								array: mysql_fetch_array
	 *								assoc: mysql_fetch_assoc
	 *								field: mysql_fetch_field
	 *								lengths: mysql_fetch_lengths
	 *								object: mysql_fetch_object
	 *								row: mysql_fetch_row
	 *								rows: mysql_num_rows
	 * @return string	結果
	 */
	function get_result($result,$mode){
		if($mode == "array") $func = "mysql_fetch_array";
		elseif($mode == "assoc") $func = "mysql_fetch_assoc";
		elseif($mode == "field") $func = "mysql_fetch_field";
		elseif($mode == "lengths") $func = "mysql_fetch_lengths";
		elseif($mode == "object") $func = "mysql_fetch_object";
		elseif($mode == "row") $func = "mysql_fetch_row";
		elseif($mode == "rows") $func = "mysql_num_rows";
		else return false;

		$rtn = @$func($result);
		return $rtn;
	}

	/**
	 * テーブル一覧読み出し
	 *
	 * @access public
	 * @return array	結果
	 */
	function show_table(){
		$rtn = array();
		$sql = "show tables";
		$result = $this->send_query($sql);
		while($row = $this->get_result($result,"array")){
			array_push($rtn,$row[0]);
		}
		return $rtn;
	}

	/**
	 * 一覧読み出し
	 *
	 * @access public
	 * @param string	$connect	リンクID
	 * @param string	$table		テーブル名
	 * @param string	$field		フィールド名
	 * @param string	$where		検索条件
	 * @param array		$param		連想配列以下参照
	 * 						+ groupby	->	GROUP BY句 集計のキーとなる列名を指定
	 *						+ having	->	HAVING句 集計結果に対する問い合わせ条件
	 *						+ orderby	->	ORDER BY句 データ並び替え
	 *						+ offset	->	OFFSET句 先頭レコード行
	 *						+ limit		->	LIMIT句 表示件数
	 * @param int		$debug_flg	デバッグ表示フラグ
	 * @return string	結果
	 */
	function select_db($table,$field,$where,$param=NULL,$debug_flg=false){
		$sql = NULL;
		$field = ($field != NULL) ? $field : "*";
		if($where != NULL) $where = " where ".$where;
		$sql = "select ".$field." from ".$table.$where;
		if(isset($param) && is_array($param)){
			if(isset($param["groupby"])) $sql .=" group by ".$param["groupby"];
			if(isset($param["having"])) $sql .=" having ".$param["having"];
			if(isset($param["orderby"])) $sql .=" order by ".$param["orderby"];
			if(isset($param["offset"]) && isset($param["limit"])) $sql .=" limit ".$param["offset"].",".$param["limit"];
		}
		$sql .= " for update";
		$rtn = $this->send_query($sql,0,$debug_flg);
		return $rtn;
	}

	/**
	 * コード作成
	 *
	 * @access public
	 * @param string	$table		テーブル名
	 * @param string	$field		フィールド名
	 * @param string	$where		検索条件
	 * @param array		$param		連想配列以下参照
	 * 						+ groupby	->	GROUP BY句 集計のキーとなる列名を指定
	 *						+ having	->	HAVING句 集計結果に対する問い合わせ条件
	 *						+ orderby	->	ORDER BY句 データ並び替え
	 *						+ offset	->	OFFSET句 先頭レコード行
	 *						+ limit		->	LIMIT句 表示件数
	 * @param string	$fld_key	添え字キーのフィールド名
	 * @param string	$fld_val	該当値のフィールド名
	 * @param string	$fld_arr	配列時の添え字に値するフィールド名
	 * @return string	結果
	 */
	function get_code_list($table,$field,$where,$param=NULL,$fld_key,$fld_val,$fld_arr=NULL){
		$str_func = new str_func();
		$rtn = NULL;
		$res = array();
		$db_rtn = $this->select_db($table,$field,$where,$param);
		if(!$db_rtn){
			return false;
		}else{
			for($cnt1=0; $cnt1<$this->get_result($db_rtn,"rows"); $cnt1++){
				$data = $str_func->encode_str($this->get_result($db_rtn,"assoc"));
				if(!isset($fld_arr)) $res[$data[$fld_key]] = $data[$fld_val];
				else $res[$data[$fld_arr]][$data[$fld_key]] = $data[$fld_val];
			}
		}
		$rtn = $res;
		return $rtn;
	}
}
?>
