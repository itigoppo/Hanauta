<?php
/**
 * flickr.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 12/01/18 last update
 * @copyright http://www.nono150.com/
 */

/**
 * FlickrAPIクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

// Jsphon
require_once("Jsphon/Decoder.php");

class flickr{
	var $api_key = "53bc11c66833caeca4eae8f84094f5e5";

	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->Jsphon = new Jsphon_Decoder();
	}

	/**
	 * Base58 decode
	 *
	 * @access public
	 * @param string	$str		変換文字
	 * @return string	decode data
	 */
	function base58_decode($str){
	    $alphabet = "123456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
		$decoded = 0;
		$multi = 1;
		while (strlen($str) > 0) {
			$digit = $str[strlen($str)-1];
			$decoded += $multi * strpos($alphabet, $digit);
			$multi = $multi * strlen($alphabet);
			$str = substr($str, 0, -1);
		}
		return $decoded;
	}

	function get_thumb($id){
		$rtn = false;

		$url = "http://www.flickr.com/services/rest?method=flickr.photos.getInfo&format=json&api_key=".$this->api_key."&photo_id=".$id;
		$data = file_get_contents($url);
		$data = str_replace("jsonFlickrApi(","",$data);
		$data = substr($data,0,strlen($data)-1); //strip out last paren

		$rtn = $this->Jsphon->decode($data);
		return $rtn;
	}
}

?>