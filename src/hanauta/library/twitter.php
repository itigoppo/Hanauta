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
	var $regist_word;
	var $regist_ng;

	/**
	 * Timeline
	 */
	var $tm_mentions = "https://api.twitter.com/1.1/statuses/mentions_timeline.json";
	var $tm_user = "https://api.twitter.com/1.1/statuses/user_timeline.json";
	var $tm_home = "https://api.twitter.com/1.1/statuses/home_timeline.json";
	var $tm_rt_of = "https://api.twitter.com/1.1/statuses/retweets_of_me.json";

	/**
	 * Tweets
	 */
	var $sm_rt = "https://api.twitter.com/1.1/statuses/retweets/%s.json";
	var $sm_show = "https://api.twitter.com/1.1/statuses/show.json";
	var $sm_destroy = "https://api.twitter.com/1.1/statuses/destroy/%s.json";
	var $sm_update = "https://api.twitter.com/1.1/statuses/update.json";
	var $sm_update_with_media = "https://api.twitter.com/1.1/statuses/update_with_media.json";
	var $sm_oembed = "https://api.twitter.com/1.1/statuses/oembed.json";
	var $sm_rt_id = "https://api.twitter.com/1.1/statuses/retweeters/ids.json";

	/**
	 * Search
	 */
	var $sh_search = "https://api.twitter.com/1.1/search/tweets.json";

	/**
	 * Streaming
	 */
	var $st_filter = "https://stream.twitter.com/1.1/statuses/filter.json";
	var $st_sample = "https://stream.twitter.com/1.1/statuses/sample.json";
	var $st_firehose = "https://stream.twitter.com/1.1/statuses/firehose.json";
	var $st_user = "https://userstream.twitter.com/1.1/user.json";
	var $st_site = "https://dev.twitter.com/docs/api/1.1/get/site";

	/**
	 * Direct Message
	 */
	var $dm_get = "https://api.twitter.com/1.1/direct_messages.json";
	var $dm_sent = "https://api.twitter.com/1.1/direct_messages/sent.json";
	var $dm_show = "https://api.twitter.com/1.1/direct_messages/show.json";
	var $dm_destroy = "https://api.twitter.com/1.1/direct_messages/destroy.json";
	var $dm_new = "https://api.twitter.com/1.1/direct_messages/new.json";

	/**
	 * Friends & Followers
	 */
	var $fm_no_rt = "https://api.twitter.com/1.1/friendships/no_retweets/ids.json";
	var $fm_friend_id = "https://api.twitter.com/1.1/friends/ids.json";
	var $fm_followers_id = "https://api.twitter.com/1.1/followers/ids.json";
	var $fm_lookup = "http://api.twitter.com/1.1/friendships/lookup.json";
	var $fm_incoming = "https://api.twitter.com/1.1/friendships/incoming.json";
	var $fm_outgoing = "http://api.twitter.com/1.1/friendships/outgoing.json";
	var $fm_create = "https://api.twitter.com/1.1/friendships/create.json";
	var $fm_destroy = "https://api.twitter.com/1.1/friendships/destroy.json";
	var $fm_update = "http://api.twitter.com/1.1/friendships/update.json";
	var $fm_show = "http://api.twitter.com/1.1/friendships/show.json";
	var $fm_friend = "https://api.twitter.com/1.1/friends/list.json";
	var $fm_followers = "https://api.twitter.com/1.1/followers/list.json";

	/**
	 * Users
	 */
	var $um_setting = "https://api.twitter.com/1.1/account/settings.json";
	var $um_verify = "https://api.twitter.com/1.1/account/verify_credentials.json";
	var $um_device = "https://api.twitter.com/1.1/account/update_delivery_device.json";
	var $um_profile = "https://api.twitter.com/1.1/account/update_profile.json";
	var $um_bg_image = "https://api.twitter.com/1.1/account/update_profile_background_image.json";
	var $um_colors = "https://api.twitter.com/1.1/account/update_profile_colors.json";
	var $um_image = "https://api.twitter.com/1.1/account/update_profile_image.json";
	var $um_blocks = "https://api.twitter.com/1.1/blocks/list.json";
	var $um_blocks_id = "https://api.twitter.com/1.1/blocks/ids.json";
	var $um_blocks_create = "https://api.twitter.com/1.1/blocks/create.json";
	var $um_blocks_destroy = "https://api.twitter.com/1.1/blocks/destroy.json";
	var $um_lookup = "https://api.twitter.com/1.1/users/lookup.json";
	var $um_show = "http://api.twitter.com/1.1/users/show.json";
	var $um_search = "https://api.twitter.com/1.1/users/search.json";
	var $um_contributees = "https://api.twitter.com/1.1/users/contributees.json";
	var $um_contributors = "https://api.twitter.com/1.1/users/contributors.json";
	var $um_remove_banner = "https://api.twitter.com/1.1/account/remove_profile_banner.json";
	var $um_update_banner = "https://api.twitter.com/1.1/account/update_profile_banner.json";
	var $um_banner = "https://api.twitter.com/1.1/users/profile_banner.json";

	/**
	 * Suggested Users
	 */
	var $su_user = "https://api.twitter.com/1.1/users/suggestions/%s.json";
	var $su_category = "https://api.twitter.com/1.1/users/suggestions.json";
	var $su_tweets = "https://api.twitter.com/1.1/users/suggestions/%s/members.json";

	/**
	 * Favorites
	 */
	var $fv_list = "https://api.twitter.com/1.1/favorites/list.json";
	var $fv_destroy = "https://api.twitter.com/1.1/favorites/destroy.json";
	var $fv_create = "https://api.twitter.com/1.1/favorites/create.json";

	/**
	 * Lists
	 */
	var $lm_list = "http://api.twitter.com/1.1/lists/list.json";
	var $lm_statuses = "https://api.twitter.com/1.1/lists/statuses.json";
	var $lm_members_destroy = "https://api.twitter.com/1.1/lists/members/destroy.json";
	var $lm_memberships = "https://api.twitter.com/1.1/lists/memberships.json";
	var $lm_subscribers = "https://api.twitter.com/1.1/lists/subscribers.json";
	var $lm_subscribers_create = "https://api.twitter.com/1.1/lists/subscribers/create.json";
	var $lm_subscribers_show = "https://api.twitter.com/1.1/lists/subscribers/show.json";
	var $lm_subscribers_destroy = "https://api.twitter.com/1.1/lists/subscribers/destroy.json";
	var $lm_create_all = "https://api.twitter.com/1.1/lists/members/create_all.json";
	var $lm_members_show = "https://api.twitter.com/1.1/lists/members/show.json";
	var $lm_members = "https://api.twitter.com/1.1/lists/members.json";
	var $lm_members_create = "https://api.twitter.com/1.1/lists/members/create.json";
	var $lm_destroy = "https://api.twitter.com/1.1/lists/destroy.json";
	var $lm_update = "https://api.twitter.com/1.1/lists/update.json";
	var $lm_create = "https://api.twitter.com/1.1/lists/create.json";
	var $lm_show = "https://api.twitter.com/1.1/lists/show.json";
	var $lm_subscriptions = "https://api.twitter.com/1.1/lists/subscriptions.json";
	var $lm_destroy_all = "https://api.twitter.com/1.1/lists/members/destroy_all.json";
	var $lm_ownerships = "https://api.twitter.com/1.1/lists/ownerships.json";

	/**
	 * Saved Searches
	 */
	var $sh_saved_list = "https://api.twitter.com/1.1/saved_searches/list.json";
	var $sh_saved_show = "https://api.twitter.com/1.1/saved_searches/show/%s.json";
	var $sh_saved_create = "https://api.twitter.com/1.1/saved_searches/create.json";
	var $sh_saved_destroy = "https://api.twitter.com/1.1/saved_searches/destroy/%s.json";

	/**
	 * Places & Geo
	 */
	var $gm_id = "https://api.twitter.com/1.1/geo/id/%s.json";
	var $gm_geocode = "https://api.twitter.com/1.1/geo/reverse_geocode.json";
	var $gm_search = "https://api.twitter.com/1.1/geo/search.json";
	var $gm_similar = "https://api.twitter.com/1.1/geo/similar_places.json";
	var $place = "https://api.twitter.com/1.1/geo/place.json";

	/**
	 * Trends
	 */
	var $tr_place = "https://api.twitter.com/1.1/trends/place.json";
	var $tr_available = "https://api.twitter.com/1.1/trends/available.json";
	var $tr_closest = "https://api.twitter.com/1.1/trends/closest.json";

	/**
	 * Spam Reporting
	 */
	var $sr_spam = "https://api.twitter.com/1.1/users/report_spam.json";

	/**
	 * OAuth Methods
	 */
	var $om_authenticate = "https://api.twitter.com/oauth/authenticate";
	var $om_authorize = "https://api.twitter.com/oauth/authorize";
	var $om_access_token = "https://api.twitter.com/oauth/access_token";
	var $om_request_token = "https://api.twitter.com/oauth/request_token";
	var $om_token = "https://api.twitter.com/oauth2/token";
	var $om_invalidate_token = "https://api.twitter.com/oauth2/invalidate_token";

	/**
	 * Help Methods
	 */
	var $hm_configuration = "https://api.twitter.com/1.1/help/configuration.json";
	var $hm_languages = "https://api.twitter.com/1.1/help/languages.json";
	var $hm_privacy = "https://api.twitter.com/1.1/help/privacy.json";
	var $hm_tos = "https://api.twitter.com/1.1/help/tos.json";
	var $hm_limit = "https://api.twitter.com/1.1/application/rate_limit_status.json";

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
		if(isset($cnf_arr["TW_SETTING_WORD"])) $this->regist_word = $cnf_arr["TW_SETTING_WORD"];
		if(isset($cnf_arr["TW_SETTING_NG"])) $this->regist_ng = $cnf_arr["TW_SETTING_NG"];
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
	 * statuses mentions access
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	count,since_id,max_id,trim_user,contributor_details,include_entities
	 * @return mix		false or xml
	 */
	function getMentions($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];
		if(isset($options["contributor_details"])) $param["contributor_details"] = $options["contributor_details"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->tm_mentions,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * statuses user_timeline access
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,since_id,count,max_id,trim_user,exclude_replies,contributor_details,include_rts
	 * @return mix		false or xml
	 */
	function getUserTimeline($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];
		if(isset($options["exclude_replies"])) $param["exclude_replies"] = $options["exclude_replies"];
		if(isset($options["contributor_details"])) $param["contributor_details"] = $options["contributor_details"];
		if(isset($options["include_rts"])) $param["include_rts"] = $options["include_rts"];

		$result = $consumer["consumer"]->sendRequest($this->tm_user,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * statuses home_timeline access
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	since_id,max_id,count,trim_user,exclude_replies,contributor_details,include_entities
	 * @return mix		false or xml
	 */
	function getHomeTimeline($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];
		if(isset($options["exclude_replies"])) $param["exclude_replies"] = $options["exclude_replies"];
		if(isset($options["contributor_details"])) $param["contributor_details"] = $options["contributor_details"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->tm_home,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * statuses retweeted_of_me access
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	count,since_id,max_id,trim_user,include_entities,include_user_entities
	 * @return mix		false or xml
	 */
	function getRtof($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["include_user_entities"])) $param["include_user_entities"] = $options["include_user_entities"];

		$result = $consumer["consumer"]->sendRequest($this->tm_rt_of,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}



	/**
	 * 認証
	 *
	 * @access public
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
				$Hanauta->obj["request"]->vars2ses("token",$data);
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