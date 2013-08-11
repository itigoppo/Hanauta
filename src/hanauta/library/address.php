<?php
/**
 * address.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 09/02/05 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 住所関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class address extends string{
	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->string();
	}

	/**
	 * 都道府県設定
	 *
	 * @access public
	 * @return array	都道府県
	 */
	function get_pref(){
		$dir_fw_cnf = constant("DIR_CNF");
		$rtn = array();

		$file = file($dir_fw_cnf."prefdata.txt");
		$file = $this->convart_charset($file,"UTF-8");
		$data = array();
		foreach($pref_file as $key => $value){
			$value = trim($value);
			$key_name = mb_substr($value, 0, 3);
			$data[$key_name] = $value;
		}

		$rtn = $data;
		return $rtn;
	}

	/**
	 * 例外市設定
	 *
	 * @access public
	 * @return array	例外市データ
	 */
	function get_city(){
		$dir_fw_cnf = constant("DIR_CNF");
		$rtn = array();

		$file = file($dir_fw_cnf."citydata.txt");
		$file = $this->convart_charset($file,"UTF-8");
		$data = array();
		foreach($file as $key => $value){
			$value = trim($value);
			$key_name = mb_substr($value, 0, 3);
			$data[$key_name] = $value;
		}

		$rtn = $data;
		return $rtn;
	}

	/**
	 * 住所分割
	 *
	 * @access public
	 * @param string	$address	住所データ
	 * @return array	住所		[0]都道府県、[1]市区町村郡、[2]その他
	 */
	function explode_address($address){
		$data = array();

		// 都道府県を設定
		$pref_data = $this->get_pref();

		// 例外市を設定
		$city_data = $this->get_city();

		// 都道府県取得
		$pref_key = mb_substr($address, 0, 3);
		$data[0] = $pref_data[$pref_key];

		// 市区町村
		$split = 0;
		$add_data = mb_substr($address, mb_strlen($data[0]));

		// 市より区が先にあるので例外
		if($data[0] == "東京都"){
			$pos = mb_strpos($add_data, "区");
			if(($pos > 0) && ($pos <= 3)) $split = $pos + 1;
		}
		// 例外市の処理
		if(!$split){
			$city = NULL;
			$city_key = mb_substr($add_data, 0, 3);
			$city = $city_data[$city_key];
			if($city != NULL) $split = mb_strlen($city);
		}
		if(!$split){
			// 市区町村郡位置検索
			$poss = array();
			$poss[0] = mb_strpos($add_data, "市");
			$poss[1] = mb_strpos($add_data, "区");
			$poss[2] = mb_strpos($add_data, "町");
			$poss[3] = mb_strpos($add_data, "村");
			$poss[4] = mb_strpos($add_data, "郡");
			// 最後に見つかったデータ優先
			rsort($poss);
			for($cnt1=0; $cnt1<5; $cnt1++){
				// 一文字目以外で区切り有効
				if($poss[$cnt1] > 0){
					$split = $poss[$cnt1] + 1;
					break;
				}
			}
		}

		if($split){
			$data[2] = mb_substr($add_data, $split);
			$data[1] = mb_substr($add_data, 0, $split);
		}
		$rtn = $data;
		return $rtn;
	}

}
?>
