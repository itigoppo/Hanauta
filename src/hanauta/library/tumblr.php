<?php
/**
 * tumblr.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 12/12/20 last update
 * @copyright http://www.nono150.com/
 */

/**
 * TumblrAPIクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

// HTTP_OAuth
require_once("HTTP/OAuth/Consumer.php");
// Jsphon
require_once("Jsphon/Decoder.php");

class tumblr{

	// Blog Methods
	var $bm_info = "http://api.tumblr.com/v2/blog/%s/info?api_key=%s";
	var $bm_avatar = "http://api.tumblr.com/v2/blog/%s/avatar%s";
	var $bm_links = "http://api.tumblr.com/v2/blog/%s/likes?api_key=%s";
	var $bm_followers = "http://api.tumblr.com/v2/blog/%s/followers";
	var $bm_posts = "http://api.tumblr.com/v2/blog/%s/posts%s?api_key=%s";
	var $bm_posts_queue = "http://api.tumblr.com/v2/blog/%s/posts/queue";
	var $bm_posts_draft = "http://api.tumblr.com/v2/blog/%s/posts/draft";
	var $bm_posts_submission = "http://api.tumblr.com/v2/blog/%s/posts/submission";
	var $bm_post = "http://api.tumblr.com/v2/blog/%s/post";
	var $bm_post_edit = "http://api.tumblr.com/v2/blog/%s/post/edit";
	var $bm_post_reblog = "http://api.tumblr.com/v2/blog/%s/post/reblog";
	var $bm_post_delete = "http://api.tumblr.com/v2/blog/%s/post/delete";

	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->Jsphon = new Jsphon_Decoder();
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
		preg_match("/<title>(.+)<\/title>/s",$content,$match);
		if(!isset($match[1])){
			// [120411]なんか&#0;でエラーがでるからカット
			$content = str_replace("&#0;", "", $content);
			$xml = new SimpleXMLElement($content);
			$rtn = $xml;
		}
		return $rtn;
	}

	/**
	 * GET Info
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getBlogInfo($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_info,$options["host_name"],$options["api_key"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET Avatar
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,size[16, 24, 30, 40, 48, 64, 96, 128, 512]
	 * @return mix		false or xml
	 */
	function getAvatar($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(!isset($options["size"])) $options["size"] = "/".$options["size"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_avatar,$options["host_name"],$options["size"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET Link
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getLink($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["limit"])) $param["limit"] = $options["limit"];
		if(isset($options["offset"])) $param["offset"] = $options["offset"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_links,$options["host_name"],$options["api_key"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET Followers
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getFollowers($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["limit"])) $param["limit"] = $options["limit"];
		if(isset($options["offset"])) $param["offset"] = $options["offset"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_followers,$options["host_name"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET Post
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getPosts($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["type"])) $options["type"] = "/".$options["type"];
		else $options["type"] = "";
		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["tag"])) $param["tag"] = $options["tag"];
		if(isset($options["limit"])) $param["limit"] = $options["limit"];
		if(isset($options["offset"])) $param["offset"] = $options["offset"];
		if(isset($options["reblog_info"])) $param["reblog_info"] = $options["reblog_info"];
		if(isset($options["notes_info"])) $param["notes_info"] = $options["notes_info"];
		if(isset($options["filter"])) $param["filter"] = $options["filter"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_posts,$options["host_name"],$options["type"],$options["api_key"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET PostsQueue
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getPostsQueue($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["limit"])) $param["limit"] = $options["limit"];
		if(isset($options["offset"])) $param["offset"] = $options["offset"];
		if(isset($options["filter"])) $param["filter"] = $options["filter"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_posts_queue,$options["host_name"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET PostsDraft
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getPostsDraft($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["filter"])) $param["filter"] = $options["filter"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_posts_draft,$options["host_name"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * GET PostsSubmission
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function getPostsSubmission($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["offset"])) $param["offset"] = $options["offset"];
		if(isset($options["filter"])) $param["filter"] = $options["filter"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_posts_submission,$options["host_name"]),$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * POST Post
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function setUpdate($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["type"])) $param["type"] = $options["type"];
		if(isset($options["state"])) $param["state"] = $options["state"];
		if(isset($options["tags"])) $param["tags"] = $options["tags"];
		if(isset($options["tweet"])) $param["tweet"] = $options["tweet"];
		if(isset($options["date"])) $param["date"] = $options["date"];
		if(isset($options["format"])) $param["format"] = $options["format"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];

		// text[body]
		if(isset($options["title"])) $param["title"] = $options["title"];
		if(isset($options["body"])) $param["body"] = $options["body"];

		// photo[source or data]
		if(isset($options["caption"])) $param["caption"] = $options["caption"];
		if(isset($options["link"])) $param["link"] = $options["link"];
		if(isset($options["source"])) $param["source"] = $options["source"];
		if(isset($options["data"])) $param["data"] = $options["data"];

		// quote[quote]
		if(isset($options["quote"])) $param["quote"] = $options["quote"];
		if(isset($options["source"])) $param["source"] = $options["source"];

		// link[url]
		if(isset($options["title"])) $param["title"] = $options["title"];
		if(isset($options["url"])) $param["url"] = $options["url"];
		if(isset($options["description"])) $param["description"] = $options["description"];

		// chat[conversation]
		if(isset($options["title"])) $param["title"] = $options["title"];
		if(isset($options["conversation"])) $param["conversation"] = $options["conversation"];

		// audio[external_url or data]
		if(isset($options["caption"])) $param["caption"] = $options["caption"];
		if(isset($options["external_url"])) $param["external_url"] = $options["external_url"];
		if(isset($options["data"])) $param["data"] = $options["data"];

		// video[embed or data]
		if(isset($options["caption"])) $param["caption"] = $options["caption"];
		if(isset($options["embed"])) $param["embed"] = $options["embed"];
		if(isset($options["data"])) $param["data"] = $options["data"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_post,$options["host_name"]),$param,"POST");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}

	/**
	 * POST PostEdit
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	host_name,api_key
	 * @return mix		false or xml
	 */
	function setUpdateEdit($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();
		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["type"])) $param["type"] = $options["type"];
		if(isset($options["state"])) $param["state"] = $options["state"];
		if(isset($options["tags"])) $param["tags"] = $options["tags"];
		if(isset($options["tweet"])) $param["tweet"] = $options["tweet"];
		if(isset($options["date"])) $param["date"] = $options["date"];
		if(isset($options["format"])) $param["format"] = $options["format"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];

		// text[body]
		if(isset($options["title"])) $param["title"] = $options["title"];
		if(isset($options["body"])) $param["body"] = $options["body"];

		// photo[source or data]
		if(isset($options["caption"])) $param["caption"] = $options["caption"];
		if(isset($options["link"])) $param["link"] = $options["link"];
		if(isset($options["source"])) $param["source"] = $options["source"];
		if(isset($options["data"])) $param["data"] = $options["data"];

		// quote[quote]
		if(isset($options["quote"])) $param["quote"] = $options["quote"];
		if(isset($options["source"])) $param["source"] = $options["source"];

		// link[url]
		if(isset($options["title"])) $param["title"] = $options["title"];
		if(isset($options["url"])) $param["url"] = $options["url"];
		if(isset($options["description"])) $param["description"] = $options["description"];

		// chat[conversation]
		if(isset($options["title"])) $param["title"] = $options["title"];
		if(isset($options["conversation"])) $param["conversation"] = $options["conversation"];

		// audio[external_url or data]
		if(isset($options["caption"])) $param["caption"] = $options["caption"];
		if(isset($options["external_url"])) $param["external_url"] = $options["external_url"];
		if(isset($options["data"])) $param["data"] = $options["data"];

		// video[embed or data]
		if(isset($options["caption"])) $param["caption"] = $options["caption"];
		if(isset($options["embed"])) $param["embed"] = $options["embed"];
		if(isset($options["data"])) $param["data"] = $options["data"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->bm_post_edit,$options["host_name"]),$param,"POST");
		$rtn = $this->Jsphon->decode($result->getBody());
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
	function tumblr_auth($sys_arr,$token){
		$request = new request();
		$_svars = $request->ses2vars();
		$_gvars = $request->get2vars();

		$consumer_key = $sys_arr["TB_CONSUMER_KEY"];
		$consumer_secret = $sys_arr["TB_CONSUMER_SECRET"];
		$callback_url = $sys_arr["TB_CALLBAK"];

		$rtn = NULL;
		$data = array();

		$consumer = new HTTP_OAuth_Consumer($consumer_key,$consumer_secret);
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
			if(isset($_svars["token"]["flg"]) && $_svars["token"]["flg"] == "start" && isset($_gvars["oauth_token"])){
				// callback
				$verifier = $_gvars["oauth_verifier"];
				$consumer->setToken($_svars["token"]['request_token']);
				$consumer->setTokenSecret($_svars["token"]['request_token_secret']);
				$consumer->getAccessToken($this->om_access_token,$verifier);
				$data["flg"] = "callback";
				$data["access_token"] = $consumer->getToken();
				$data["access_token_secret"] = $consumer->getTokenSecret();
				$request->vars2ses("token",$data);
				$rtn = "callback";
				header("Location: ".$sys_arr["TW_CALLBAK"]);
				exit;
			}else{
				// 認証用URL作成
				$consumer->getRequestToken($this->om_request_token,$callback_url);
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