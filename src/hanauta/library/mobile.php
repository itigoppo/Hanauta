<?php
/**
 * mobile.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 13/08/10 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 携帯関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

require_once(dirname(dirname(__FILE__))."/vendors/lib3gk/lib3gk.php");

class mobile{

	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->Lib3gk = new Lib3gk();
		$this->Lib3gk->initialize();
		$this->Lib3gk->__load_tools();
	}

	/**
	 * キャリアチェック
	 *
	 * @access public
	 * @return string	キャリア
	 */
	function get_carrier(){
		$rtn = NULL;
		if($this->Lib3gk->is_iphone() || $this->Lib3gk->is_android()){
			$str = "sp";
		}else if($this->Lib3gk->is_ktai() || $this->Lib3gk->is_phs()){
			$str = "mb";
		}else{
			$str = "pc";
		}

		$rtn = $str;
		return $rtn;
	}

	/**
	 * UID取得
	 *
	 * @access public
	 * @return string	UID
	 */
	function get_uid(){
		$rtn = NULL;

		$str = $this->Lib3gk->get_uid();
		// $this->get_sub()."@";
		$rtn = $str;
		return $rtn;
	}

	/**
	 * ユーザーエージェントチェック
	 *
	 * @access public
	 * @param string	$agent		エージェント
	 * @return string	エージェント
	 */
	function check_agent($agent){
		$rtn = NULL;
		if(strpos($agent,"DoCoMo") !== false){
			$str = "docomo";
		}elseif(strpos($agent,"SoftBank") !== false){
			$str = "softbank";
		}elseif(strpos($agent,"Vodafone") !== false || strpos($agent,"MOT-") !== false){
			$str = "softbank";
		}elseif(strpos($agent,"J-PHONE") !== false){
			$str = "softbank";
		}elseif(strpos($agent,"KDDI-") !== false || strpos($agent,"UP.Browser") !== false){
			$str = "au";
		}elseif(strpos($agent,"WILLCOM") !== false || strpos($agent,"DDIPOCKET") !== false || strpos($agent,"SHARP/WS") !== false){
			$str = "willcom";
		}elseif(strpos($agent,"iPhone") !== false || strpos($agent,"iPod") !== false){
			$str = "iphone";
		}elseif(strpos($agent,"Nintendo Wii;") !== false || strpos($agent,"Nitro") !== false || strpos($agent,"PlayStation Portable") !== false || strpos($agent,"PLAYSTATION 3;") !== false){
			$str = "other";
		}elseif(strpos($agent,"L-MODE") !== false || strpos($agent,"EGBROWSER") !== false || strpos($agent,"AveFront") !== false || strpos($agent,"ASTEL") !== false || strpos($agent,"PDXGW") !== false){
			$str = "other";
		}else{
			$str = "pc";
		}

		$rtn = $str;
		return $rtn;
	}

	/**
	 * 各種番号取得
	 *
	 * @access public
	 * @return array	$ser		DoCoMo端末製造番号
	 * 					$icc		FOMAカード製造番号
	 * 					$dgd		iモードID
	 * 					$srn		SoftBank端末製造番号
	 * 					$sud		SoftBankユーザーID
	 * 					$ezn		AUユーザーID
	 *					http://www.ezinfo.jp/php/functions
	 */
	function get_sub(){
		$rtn = array();
		$agent = $_SERVER["HTTP_USER_AGENT"];
		$env = $this->check_agent($agent);

		if($env === "docomo"){
			if(preg_match("/ser([a-zA-Z0-9]+)/",$agent,$dprg)){
				if(strlen($dprg[1]) === 11){
					// FOMA以外
					$ser = $dprg[1];
				}elseif(strlen($dprg[1]) === 15){
					// FOMA
					$ser = $dprg[1];
					if(preg_match("/icc([a-zA-Z0-9]+)/",$agent,$dpeg)){
						if(strlen($dpeg[1]) === 20){
							$icc = $dpeg[1];
						}
					}
				}
			}
			$dgd = $_SERVER['HTTP_X_DCMGUID'];
		}elseif($env === "softbank"){
			if(preg_match("/\/SN([a-zA-Z0-9]+)\//",$agent,$vprg)){
				$srn = $vprg[1];
			}
			$sud = $_SERVER['HTTP_X_JPHONE_UID'];
		}elseif($env === "au"){
			$ezn = $_SERVER['HTTP_X_UP_SUBNO'];
		}
		$rtn = array(
				$ser,
				$icc,
				$dgd,
				$srn,
				$sud,
				$ezn
		);

		return $rtn;
	}
}
?>
