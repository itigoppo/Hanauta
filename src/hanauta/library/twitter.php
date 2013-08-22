<?php
/**
 * twitter.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 13/08/10 last update
 * @copyright http://www.nono150.com/
 */

/**
 * TwitterAPIクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

// HTTP_OAuth
require_once("HTTP/OAuth/Consumer.php");
// Jsphon
require_once("Jsphon/Decoder.php");

class twitter{
	var $consumer_key;
	var $consumer_secret;
	var $callback_url;

	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->Jsphon = new Jsphon_Decoder();
		$dir_cnf = constant("DIR_API");
		$cnf_arr = parse_ini_file($dir_cnf."twitter.ini");

		$this->consumer_key = $cnf_arr["TW_CONSUMER_KEY"];
		$this->consumer_secret = $cnf_arr["TW_CONSUMER_SECRET"];
		$this->callback_url = $cnf_arr["TW_CALLBAK"];
	}

	/**
	 * GET request data
	 *
	 * @access private
	 * @param object	$result		オブジェクト
	 * @return mix		false or xml
	 */
	function _getBody($result){
		$rtn = false;

		$content = $result->getBody();
		$rtn["status"] = $this->Jsphon->decode($content);
		$head = $result->getHeader();
		if(isset($head["status"])) $rtn["head_status"] = $head["status"];
		if(isset($head["x-rate-limit-limit"])) $rtn["hourly-limit"] = $head["x-rate-limit-limit"];
		if(isset($head["x-rate-limit-remaining"])) $rtn["remaining-hits"] = $head["x-rate-limit-remaining"];
		if(isset($head["x-rate-limit-reset"])) $rtn["reset-time"] = $head["x-rate-limit-reset"];
		return $rtn;
	}

	/**
	 * 認証
	 *
	 * @access public
	 * @param array		$sys_arr	システム情報データ
	 * @param array		$token		token方法
	 * @return mix		url or object
	 */
	function twitter_auth($token){
		global $Hanauta;

		$rtn = NULL;
		$data = array();

		$consumer = new HTTP_OAuth_Consumer($this->consumer_key,$this->consumer_secret);
		// SSL通信対応
		$http_request = new HTTP_Request2();
		$http_request->setConfig("ssl_verify_peer", false);
		$consumer_request = new HTTP_OAuth_Consumer_Request;
		$consumer_request->accept($http_request);
		$consumer->accept($consumer_request);

		if($token["auth_flg"]){
			// 認証済み
			$consumer->setToken($token['access_token']);
			$consumer->setTokenSecret($token['access_token_secret']);
			$rtn = $consumer;
		}else{
			// 未認証
			if(isset($Hanauta->_svars["token"]["flg"]) && $Hanauta->_svars["token"]["flg"] == "start" && isset($Hanauta->_gvars["oauth_token"])){
				// callback
				$verifier = $Hanauta->_gvars["oauth_verifier"];
				$consumer->setToken($Hanauta->_svars["token"]['request_token']);
				$consumer->setTokenSecret($Hanauta->_svars["token"]['request_token_secret']);
				$consumer->getAccessToken($this->om_access_token,$verifier);
				$data["flg"] = "callback";
				$data["access_token"] = $consumer->getToken();
				$data["access_token_secret"] = $consumer->getTokenSecret();
				$request->vars2ses("token",$data);
				$rtn = "callback";
				header("Location: ".$this->callback_url);
				exit;
			}else{
				// 認証用URL作成
				$consumer->getRequestToken($this->om_request_token,$this->callback_url);
				$data["flg"] = "start";
				$data["request_token"] = $consumer->getToken();
				$data["request_token_secret"] = $consumer->getTokenSecret();
				$request->vars2ses("token",$data);
				$auth_url = $consumer->getAuthorizeUrl($this->om_authorize);
				$rtn = $auth_url;
			}
		}
		return $rtn;
	}

	/**
	 * 日付フォーマット
	 *
	 * @access public
	 * @param date		$date		変換元日付
	 * @param string	$format		変換フォーマット
	 * @return date		date
	 */
	function format_date($date,$stamp=false,$format="Y/m/d H:i:s"){
		$rtn = NULL;
		$data = NULL;

		$date_arr = preg_replace("/^(\w+) (\w+) (\d+) ([\d:]+) (\+0000) (\d+)$/i","$1,$3 $2 $6 $5 $4",$date);
		if(!$stamp) $data = strtotime(str_replace("+0000 ","",$date_arr." GMT"));
		else $data = $date;
		$data = date($format,$data);

		$rtn = $data;
		return $rtn;
	}

	/**
	 * ポスト日付フォーマット
	 *
	 * @access public
	 * @param date		$date		変換元日付
	 * @return string	date
	 */
	function format_post_date($date){
		$rtn = NULL;
		$data = NULL;

		$date_arr = preg_replace("/^(\w+) (\w+) (\d+) ([\d:]+) (\+0000) (\d+)$/i","$1,$3 $2 $6 $5 $4",$date);
		$data = (time() - strtotime(str_replace("+0000 ","",$date_arr." GMT")));
		if($data < 60) $data = "less than a minute ago";
		elseif($data < 120) $data = "about a minute ago";
		elseif($data < (45 * 60)) $data = ceil($data / 60)." minutes ago";
		elseif($data < (90 * 60)) $data = "about an hour ago";
		elseif($data < (24 * 60 * 60)) $data = "about ".ceil($data / 3600)." hours ago";
		elseif($data < (48 * 60 * 60)) $data = "1 day ago";
		else $data = ceil($data / 86400)." days ago";

		$rtn = $data;
		return $rtn;
	}

	/**
	 * ソースフォーマット
	 *
	 * @access public
	 * @param string	$text		変換元テキスト
	 * @return string	text
	 */
	function format_source($text){
		$rtn = NULL;
		$pattern = "/<a href=\"?([^\"\s]+).*?>(.+?)<\/a>/";
		$link = preg_replace($pattern,"\\1",$text);
		$source = preg_replace($pattern,"\\2",$text);
		if(!$source) $source = $text;

		$rtn_arr = array("link"=>$link,"source"=>$source);
		$rtn = $rtn_arr;
		return $rtn;
	}

}

?>