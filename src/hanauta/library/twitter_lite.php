<?php
/**
 * twitter_lite.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/05/16 last update
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

class twitter_lite{
	/**
	 * Search Methods
	 */
	var $sh_search = "http://search.twitter.com/search.json";
	var $sh_search_atom = "http://search.twitter.com/search.atom";
	var $sh_trends = "http://search.twitter.com/trends.json";
	var $sh_trends_current = "http://search.twitter.com/trends/current.json";
	var $sh_trends_daily = "http://search.twitter.com/trends/daily.json";
	var $sh_trends_weekly = "http://search.twitter.com/trends/weekly.json";
	
	/**
	 * Timeline Methods
	 */
	var $tm_public = "http://api.twitter.com/1/statuses/public_timeline.xml";
	var $tm_home = "http://api.twitter.com/1/statuses/home_timeline.xml";
	var $tm_friends = "http://api.twitter.com/1/statuses/friends_timeline.xml";
	var $tm_user = "http://api.twitter.com/1/statuses/user_timeline.xml";
	var $tm_user_target = "http://api.twitter.com/1/statuses/user_timeline/%s.xml";
	var $tm_mentions = "http://api.twitter.com/1/statuses/mentions.xml";
	var $tm_rt_by = "http://api.twitter.com/1/statuses/retweeted_by_me.xml";
	var $tm_rt_to = "http://api.twitter.com/1/statuses/retweeted_to_me.xml";
	var $tm_rt_of = "http://api.twitter.com/1/statuses/retweets_of_me.xml";
	
	/**
	 * Status Methods
	 */
	var $sm_show = "http://api.twitter.com/1/statuses/show/%s.xml";
	var $sm_update = "http://api.twitter.com/1/statuses/update.xml";
	var $sm_destroy = "http://api.twitter.com/1/statuses/destroy/%s.xml";
	var $sm_retweet = "http://api.twitter.com/1/statuses/retweet/%s.xml";
	var $sm_retweets = "http://api.twitter.com/1/statuses/retweets/%s.xml";
	
	/**
	 * User Methods
	 */
	var $um_show = "http://api.twitter.com/1/users/show/%s.xml";
	var $um_lookup = "http://api.twitter.com/1/users/lookup.xml";
	var $um_search = "http://api.twitter.com/1/users/search.xml";
	var $um_friends = "http://api.twitter.com/1/statuses/friends.xml";
	var $um_friends_target = "http://api.twitter.com/1/statuses/friends/%s.xml";
	var $um_followers = "http://api.twitter.com/1/statuses/followers.xml";
	var $um_followers_target = "http://api.twitter.com/1/statuses/followers/%s.xml";
	
	/**
	 * List Methods
	 */
	var $lm_create= "http://api.twitter.com/1/%s/lists.xml";
	var $lm_update= "http://api.twitter.com/1/%s/lists/%s.xml";
	var $lm_index= "http://api.twitter.com/1/%s/lists.xml";
	var $lm_show= "http://api.twitter.com/1/%s/lists/%s.xml";
	var $lm_destroy= "http://api.twitter.com/1/%s/lists/%s.xml";
	var $lm_statuses= "http://api.twitter.com/1/%s/lists/%s/statuses.xml";
	var $lm_memberships= "http://api.twitter.com/1/%s/lists/memberships.xml";
	var $lm_subscriptions= "http://api.twitter.com/1/%s/lists/subscriptions.xml";
	
	/**
	 * List Members Methods
	 */
	var $lm_members_index = "http://api.twitter.com/1/%s/%s/members.xml";
	var $lm_members_create = "http://api.twitter.com/1/%s/%s/members.xml";
	var $lm_members_destroy = "http://api.twitter.com/1/%s/%s/members.xml";
	var $lm_members_show = "http://api.twitter.com/1/%s/%s/members/%s.xml";
	
	/**
	 * List Subscribers Methods
	 */
	var $lm_subscribers_index = "http://api.twitter.com/1/%s/%s/subscribers.xml";
	var $lm_subscribers_create = "http://api.twitter.com/1/%s/%s/subscribers.xml";
	var $lm_subscribers_destroy = "http://api.twitter.com/1/%s/%s/subscribers.xml";
	var $lm_subscribers_show = "http://api.twitter.com/1/%s/%s/subscribers/%s.xml";
	
	/**
	 * Direct Message Methods
	 */
	var $dm_index = "http://api.twitter.com/1/direct_messages.xml";
	var $dm_sent = "http://api.twitter.com/1/direct_messages/sent.xml";
    var $dm_new  = 'http://twitter.com/direct_messages/new.xml';
	var $dm_destroy = "http://api.twitter.com/1/direct_messages/destroy/%s.xml";
	
	/**
	 * Friendship Methods
	 */
	var $fm_create = "http://api.twitter.com/1/friendships/create/%s.xml";
	var $fm_destroy = "http://api.twitter.com/1/friendships/destroy/%s.xml";
	var $fm_exists = "http://api.twitter.com/1/friendships/exists.xml";
	var $fm_show = "http://api.twitter.com/1/friendships/show.xml";
	
	/**
	 * Social Graph Methods
	 */
	var $sg_friends = "http://api.twitter.com/1/friends/ids.xml";
	var $sg_friends_target = "http://api.twitter.com/1/friends/ids/%s.xml";
	var $sg_followers = "http://api.twitter.com/1/followers/ids.xml";
	var $sg_followers_target = "http://api.twitter.com/1/followers/ids/%s.xml";
	
	/**
	 * Account Methods
	 */
	var $am_verify = "http://api.twitter.com/1/account/verify_credentials.xml";
	var $am_limit = "http://api.twitter.com/1/account/rate_limit_status.xml";
	var $am_end = "http://api.twitter.com/1/account/end_session.xml";
	var $am_device = "http://api.twitter.com/1/account/update_delivery_device.xml";
	var $am_colors = "http://api.twitter.com/1/account/update_profile_colors.xml";
	var $am_image = "http://api.twitter.com/1/account/update_profile_image.xml";
	var $am_background_image = "http://api.twitter.com/1/account/update_profile_background_image.xml";
	var $am_profile = "http://api.twitter.com/1/account/update_profile.xml";
	
	/**
	 * Favorite Methods
	 */
	var $fv_index = "http://api.twitter.com/1/favorites.xml";
	var $fv_index_target = "http://api.twitter.com/1/favorites/%s.xml";
	var $fv_create = "http://api.twitter.com/1/favorites/create/%s.xml";
	var $fv_destroy = "http://api.twitter.com/1/favorites/destroy/%s.xml";
	
	/**
	 * Notification Methods
	 */
	var $nm_follow = "http://api.twitter.com/1/notifications/follow/%s.xml";
	var $nm_leave = "http://api.twitter.com/1/notifications/leave/%s.xml";
	
	/**
	 * Block Methods
	 */
	var $bm_create = "http://api.twitter.com/1/blocks/create/%s.xml";
	var $bm_destroy = "http://api.twitter.com/1/blocks/destroy/%s.xml";
	var $bm_exists = "http://api.twitter.com/1/blocks/exists/%s.xml";
	var $bm_blocking = "http://api.twitter.com/1/blocks/blocking.xml";
	var $bm_blocking_ids = "http://api.twitter.com/1/blocks/blocking/ids.xml";
	
	/**
	 * Spam Reporting Methods
	 */
	var $rm_spam = "http://api.twitter.com/1/report_spam.xml";
	
	/**
	 * Saved Searches Methods
	 */
	var $sm_saved_searches = "http://api.twitter.com/1/saved_searches.xml";
	var $sm_saved_show = "http://api.twitter.com/1/saved_searches/show/%s.xml";
	var $sm_saved_create = "http://api.twitter.com/1/saved_searches/create.xml";
	var $sm_saved_destroy = "http://api.twitter.com/1/saved_searches/destroy/%s.xml";
	
	/**
	 * OAuth Methods
	 */
	var $om_request_token = "https://twitter.com/oauth/request_token";
	var $om_authorize = "http://twitter.com/oauth/authorize";
	var $om_authenticate = "http://twitter.com/oauth/authenticate";
	var $om_access_token = "https://twitter.com/oauth/access_token";
	
	/**
	 * Local Trends Methods
	 */
	var $lt_available = "http://api.twitter.com/1/trends/available.xml";
	var $lt_woeid = "http://api.twitter.com/1/trends/woeid.xml";
	
	/**
	 * Geo Methods
	 */
	var $gm_nearby = "http://api.twitter.com/1/geo/nearby_places.json";
	var $gm_reverse = "http://api.twitter.com/1/geo/reverse_geocode.json";
	var $gm_id = "http://api.twitter.com/1/geo/%s.json";
	
	/**
	 * Help Methods
	 */
	var $hm_test = "http://api.twitter.com/1/help/test.xml";
	
	/**
	 * コンストラクタ
	 */
	function twitter_lite($application,$token=false){
		// OAuth
		$consumer_key = $application["consumer_key"];
		$consumer_secret = $application["consumer_secret"];
		$callback_url = $application["callback_url"];
		$this->consumer = new HTTP_OAuth_Consumer($consumer_key,$consumer_secret);
		// SSL通信対応
		$http_request = new HTTP_Request2();
		$http_request->setConfig("ssl_verify_peer", false);
		$consumer_request = new HTTP_OAuth_Consumer_Request;
		$consumer_request->accept($http_request);
		$this->consumer->accept($consumer_request);
		// APIアクセス
		if($token){
			$this->consumer->setToken($token['access_token']);
			$this->consumer->setTokenSecret($token['access_token_secret']);
		}else{
			if(isset($_GET["oauth_token"])){
				$verifier = $_GET["oauth_verifier"];
				$this->consumer->setToken($_SESSION["token"]['request_token']);
				$this->consumer->setTokenSecret($_SESSION["token"]['request_token_secret']);
				$this->consumer->getAccessToken($this->om_access_token,$verifier);
				$this->token->access_token = $this->consumer->getToken();
				$this->token->access_token_secret = $this->consumer->getTokenSecret();
				session_destroy();
			}else{
				$this->consumer->getRequestToken($this->om_request_token,$callback_url);
				$_SESSION["token"]["request_token"] = $this->consumer->getToken();
				$_SESSION["token"]["request_token_secret"] = $this->consumer->getTokenSecret();
				$this->token->auth_url = $this->consumer->getAuthorizeUrl($this->om_authorize);
			}
		}

		// Json
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
			$xml = new SimpleXMLElement($content);
			$head = $result->getHeader();
			if(isset($head["status"])) $xml->head_status = $head["status"];
			if(isset($head["x-ratelimit-limit"])) $xml->{"hourly-limit"} = $head["x-ratelimit-limit"];
			if(isset($head["x-ratelimit-remaining"])) $xml->{"remaining-hits"} = $head["x-ratelimit-remaining"];
			if(isset($head["x-ratelimit-reset"])) $xml->{"reset-time"} = $head["x-ratelimit-reset"];
			$rtn = $xml;
		}
		return $rtn;
	}
	
	/**
	 * search access
	 * 
	 * @access public
	 * @param array		$options	callback,lang,locale,max_id,q,rpp,page,since,since_id,geocode,show_user,until,result_type
	 * @return mix		false or array
	 */
	function getSearch($options=false){
		$rtn = false;
		$param = array();
		
		if(isset($options["callback"])) $param["callback"] = $options["callback"];
		if(isset($options["lang"])) $param["lang"] = $options["lang"];
		if(isset($options["locale"])) $param["locale"] = $options["locale"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["q"])) $param["q"] = $options["q"];
		if(isset($options["rpp"])) $param["rpp"] = $options["rpp"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		if(isset($options["since"])) $param["since"] = $options["since"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["geocode"])) $param["geocode"] = $options["geocode"];
		if(isset($options["show_user"])) $param["show_user"] = $options["show_user"];
		if(isset($options["until"])) $param["until"] = $options["until"];
		if(isset($options["result_type"])) $param["result_type"] = $options["result_type"];
		
		$result = $this->consumer->sendRequest($this->sh_search,$param,"GET");
		//$result = $this->consumer->sendRequest($this->sh_search_atom,$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}
	
	/**
	 * trends access
	 * 
	 * @access public
	 * @return mix		false or array
	 */
	function getTrends(){
		$rtn = false;
		$param = array();
	
		$result = $this->consumer->sendRequest($this->sh_trends,$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}
	
	/**
	 * trends current access
	 * 
	 * @access public
	 * @param array		$options	exclude
	 * @return mix		false or array
	 */
	function getTrendsCurrent($options=false){
		$rtn = false;
		$param = array();
		
		if(isset($options["exclude"])) $param["exclude"] = $options["exclude"];
		
		$result = $this->consumer->sendRequest($this->sh_trends_current,$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}
	
	/**
	 * trends daily access
	 * 
	 * @access public
	 * @param array		$options	date,exclude
	 * @return mix		false or array
	 */
	function getTrendsDaily($options=false){
		$rtn = false;
		$param = array();
		
		if(isset($options["date"])) $param["date"] = $options["date"];
		if(isset($options["exclude"])) $param["exclude"] = $options["exclude"];
		
		$result = $this->consumer->sendRequest($this->sh_trends_daily,$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}
	
	/**
	 * trends weekly access
	 * 
	 * @access public
	 * @param array		$options	date,exclude
	 * @return mix		false or array
	 */
	function getTrendsWeekly($options=false){
		$rtn = false;
		$param = array();
		
		if(isset($options["date"])) $param["date"] = $options["date"];
		if(isset($options["exclude"])) $param["exclude"] = $options["exclude"];
		
		$result = $this->consumer->sendRequest($this->sh_trends_weekly,$param,"GET");
		$rtn = $this->Jsphon->decode($result->getBody());
		return $rtn;
	}
	
	/**
	 * statuses public_timeline access
	 * 
	 * @access public
	 * @return mix		false or xml
	 */
	function getPublicTimeline(){
		$rtn = false;
		$param = array();
		$result = $this->consumer->sendRequest($this->tm_public,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses home_timeline access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getHomeTimeline($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->tm_home,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses friends_timeline access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getFriendsTimeline($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->tm_friends,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses user_timeline access
	 * 
	 * @access public
	 * @param array		$options	id,since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getUserTimeline($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		if(isset($options["id"])) $result = $this->consumer->sendRequest(sprintf($this->tm_user_target, $options["id"]),$param,"GET");
		else $result = $this->consumer->sendRequest($this->tm_user,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses mentions access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getMentions($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->tm_mentions,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses retweeted_by_me access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getRtby($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->tm_rt_by,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses retweeted_to_me access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getRtto($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->tm_rt_to,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses retweeted_of_me access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getRtof($options=false){
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->tm_rt_of,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses show access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function getStatusShow($options=false){
		$rtn = false;
		$param = array();

		$result = $this->consumer->sendRequest(sprintf($this->sm_show, $options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses update access
	 * 
	 * @access public
	 * @param array		$options	status,in_reply_to_status_id,lat,long,place_id,display_coordinates
	 * @return mix		false or xml
	 */
	function setUpdate($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["status"])) $param["status"] = $options["status"];
		if(isset($options["in_reply_to_status_id"])) $param["in_reply_to_status_id"] = $options["in_reply_to_status_id"];
		if(isset($options["lat"])) $param["lat"] = $options["lat"];
		if(isset($options["long"])) $param["long"] = $options["long"];
		if(isset($options["place_id"])) $param["place_id"] = $options["place_id"];
		if(isset($options["display_coordinates"])) $param["display_coordinates"] = $options["display_coordinates"];

		$result = $this->consumer->sendRequest($this->sm_update,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * statuses destroy access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function destroyStatus($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->sm_destroy, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses retweet access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function setRetweet($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->sm_retweet, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses retweets access
	 * 
	 * @access public
	 * @param array		$options	id,count
	 * @return mix		false or xml
	 */
	function getRetweet($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["count"])) $param["count"] = $options["count"];
		$result = $this->consumer->sendRequest(sprintf($this->sm_retweets, $options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * users show access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function getUserShow($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->um_show, $options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * users lookup access
	 * 
	 * @access public
	 * @param array		$options	user_id,screen_name
	 * @return mix		false or xml
	 */
	function getUserLookup($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		$result = $this->consumer->sendRequest($this->um_lookup,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * users search access
	 * 
	 * @access public
	 * @param array		$options	q,per_page,page
	 * @return mix		false or xml
	 */
	function getUserSearch($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["q"])) $param["q"] = $options["q"];
		if(isset($options["per_page"])) $param["per_page"] = $options["per_page"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		$result = $this->consumer->sendRequest($this->um_search,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses friends access
	 * 
	 * @access public
	 * @param array		$options	id,user_id,screen_name,cursor
	 * @return mix		false or xml
	 */
	function getFriends($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		if(isset($options["id"])) $result = $this->consumer->sendRequest(sprintf($this->um_friends_target, $options["id"]),$param,"GET");
		else $result = $this->consumer->sendRequest($this->um_friends,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * statuses followers access
	 * 
	 * @access public
	 * @param array		$options	id,user_id,screen_name,cursor
	 * @return mix		false or xml
	 */
	function getFollowers($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		if(isset($options["id"])) $result = $this->consumer->sendRequest(sprintf($this->um_followers_target, $options["id"]),$param,"GET");
		else $result = $this->consumer->sendRequest($this->um_followers,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * POST lists access
	 * 
	 * @access public
	 * @param array		$options	user,name,mode,description
	 * @return mix		false or xml
	 */
	function createList($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["name"])) $param["name"] = $options["name"];
		if(isset($options["mode"])) $param["mode"] = $options["mode"];
		if(isset($options["description"])) $param["description"] = $options["description"];
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_create, $options["user"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * POST lists id access
	 * 
	 * @access public
	 * @param array		$options	user,id,name,mode,description
	 * @return mix		false or xml
	 */
	function updateList($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["name"])) $param["name"] = $options["name"];
		if(isset($options["mode"])) $param["mode"] = $options["mode"];
		if(isset($options["description"])) $param["description"] = $options["description"];
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_update,$options["user"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET lists access
	 * 
	 * @access public
	 * @param array		$options	user,cursor
	 * @return mix		false or xml
	 */
	function getList($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_index, $options["user"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list id access
	 * 
	 * @access public
	 * @param array		$options	user,id
	 * @return mix		false or xml
	 */
	function getListShow($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_show,$options["user"],$options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * DELETE list id access
	 * 
	 * @access public
	 * @param array		$options	user,id
	 * @return mix		false or xml
	 */
	function destroyList($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_destroy,$options["user"],$options["id"]),$param,"DELETE");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list statuses access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,since_id,max_id,per_page,page
	 * @return mix		false or xml
	 */
	function getListStatues($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["per_page"])) $param["per_page"] = $options["per_page"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_statuses,$options["user"],$options["list_id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list memberships access
	 * 
	 * @access public
	 * @param array		$options	user,id,cursor
	 * @return mix		false or xml
	 */
	function getListMemberships($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_memberships,$options["user"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list subscriptions access
	 * 
	 * @access public
	 * @param array		$options	user,cursor
	 * @return mix		false or xml
	 */
	function getListSubscription($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_subscriptions,$options["user"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list members access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,cursor
	 * @return mix		false or xml
	 */
	function getListMembers($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_members_index,$options["user"],$options["list_id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * POST list members access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,id
	 * @return mix		false or xml
	 */
	function createListMembers($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["id"])) $param["id"] = $options["id"];
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_members_create,$options["user"],$options["list_id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * DELETE list members access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,id
	 * @return mix		false or xml
	 */
	function destroyListMembers($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["id"])) $param["id"] = $options["id"];
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_members_destroy,$options["user"],$options["list_id"]),$param,"DELETE");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list members id access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,id
	 * @return mix		false or xml
	 */
	function getListMembersShow($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_members_show,$options["user"],$options["list_id"],$options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list subscribers access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,cursor
	 * @return mix		false or xml
	 */
	function getListSubscribers($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_subscribers_index,$options["user"],$options["list_id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * POST list subscribers access
	 * 
	 * @access public
	 * @param array		$options	user,list_id
	 * @return mix		false or xml
	 */
	function createListSubscribers($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_subscribers_create,$options["user"],$options["list_id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * DELETE list subscribers access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,id
	 * @return mix		false or xml
	 */
	function destroyListSubscribers($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["id"])) $param["id"] = $options["id"];
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_subscribers_destroy,$options["user"],$options["list_id"]),$param,"DELETE");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * GET list subscribers id access
	 * 
	 * @access public
	 * @param array		$options	user,list_id,id
	 * @return mix		false or xml
	 */
	function getListSubscribersShow($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->lm_subscribers_show,$options["user"],$options["list_id"],$options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * direct messages access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getDirectMessages($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		
		$result = $this->consumer->sendRequest($this->dm_index,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * direct messages sent access
	 * 
	 * @access public
	 * @param array		$options	since_id,max_id,count,page
	 * @return mix		false or xml
	 */
	function getDirectMessagesSent($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		
		$result = $this->consumer->sendRequest($this->dm_sent,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * direct messages new access
	 * 
	 * @access public
	 * @param array		$options	user,text
	 * @return mix		false or xml
	 */
	function setDirectMessages($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user"])) $param["user"] = $options["user"];
		if(isset($options["text"])) $param["text"] = $options["text"];
		
		$result = $this->consumer->sendRequest($this->dm_new,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * direct messages destroy access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function destroyDirectMessages($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->dm_destroy,$options["id"]),$param,"DELETE");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * friendships create access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function createFriend($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->fm_create,$options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * friendships destroy access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function destroyFriend($options=false){
		$rtn = false;
		$param = array();
	
		$result = $this->consumer->sendRequest(sprintf($this->fm_destroy,$options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * friendships exists access
	 * 
	 * @access public
	 * @param array		$options	user_a,user_b
	 * @return mix		false or xml
	 */
	function getFriendExists($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user_a"])) $param["user_a"] = $options["user_a"];
		if(isset($options["user_b"])) $param["user_b"] = $options["user_b"];
		
		$result = $this->consumer->sendRequest($this->fm_exists,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * friendships show access
	 * 
	 * @access public
	 * @param array		$options	source_id,target_id
	 * @return mix		false or xml
	 */
	function getFriendShow($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["source_id"])) $param["source_id"] = $options["source_id"];
		if(isset($options["target_id"])) $param["target_id"] = $options["target_id"];
		
		$result = $this->consumer->sendRequest($this->fm_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * friends ids access
	 * 
	 * @access public
	 * @param array		$options	id,user_id,screen_name,cursor
	 * @return mix		false or xml
	 */
	function getFriend($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		if(isset($options["id"])) $result = $this->consumer->sendRequest(sprintf($this->sg_friends_target, $options["id"]),$param,"GET");
		else $result = $this->consumer->sendRequest($this->sg_friends,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * followers ids access
	 * 
	 * @access public
	 * @param array		$options	id,user_id,screen_name,cursor
	 * @return mix		false or xml
	 */
	function getFollower($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		else $param["cursor"] = -1;
		
		if(isset($options["id"])) $result = $this->consumer->sendRequest(sprintf($this->sg_followers_target, $options["id"]),$param,"GET");
		else $result = $this->consumer->sendRequest($this->sg_followers,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account verify credentials access
	 * 
	 * @access public
	 * @return mix		false or xml
	 */
	function checkAuth(){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest($this->am_verify,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account rate limit status access
	 * 
	 * @access public
	 * @return mix		false or xml
	 */
	function getLimitStatus(){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest($this->am_limit,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account end session access
	 * 
	 * @access public
	 * @return mix		false or xml
	 */
	function endAuth(){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest($this->am_end,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account update delivery device access
	 * 
	 * @access public
	 * @param array		$options	device
	 * @return mix		false or xml
	 */
	function setDevice($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["device"])) $param["device"] = $options["device"];
		
		$result = $this->consumer->sendRequest($this->am_device,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account update profile colors access
	 * 
	 * @access public
	 * @param array		$options	profile_background_color,profile_text_color,profile_link_color,profile_sidebar_fill_color,profile_sidebar_border_color
	 * @return mix		false or xml
	 */
	function setColors($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["profile_background_color"])) $param["profile_background_color"] = $options["profile_background_color"];
		if(isset($options["profile_text_color"])) $param["profile_text_color"] = $options["profile_text_color"];
		if(isset($options["profile_link_color"])) $param["profile_link_color"] = $options["profile_link_color"];
		if(isset($options["profile_sidebar_fill_color"])) $param["profile_sidebar_fill_color"] = $options["profile_sidebar_fill_color"];
		if(isset($options["profile_sidebar_border_color"])) $param["profile_sidebar_border_color"] = $options["profile_sidebar_border_color"];
		
		$result = $this->consumer->sendRequest($this->am_colors,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account update profile image access
	 * 
	 * @access public
	 * @param array		$options	image
	 * @return mix		false or xml
	 */
	function setImage($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["image"])) $param["image"] = $options["image"];
		
		$result = $this->consumer->sendRequest($this->am_image,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account update profile background image access
	 * 
	 * @access public
	 * @param array		$options	image
	 * @return mix		false or xml
	 */
	function setBgImage($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["image"])) $param["image"] = $options["image"];
		
		$result = $this->consumer->sendRequest($this->am_background_image,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * account update profile access
	 * 
	 * @access public
	 * @param array		$options	name,url,location,description
	 * @return mix		false or xml
	 */
	function setProfile($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["name"])) $param["name"] = $options["name"];
		if(isset($options["url"])) $param["url"] = $options["url"];
		if(isset($options["location"])) $param["location"] = $options["location"];
		if(isset($options["description"])) $param["description"] = $options["description"];
		
		$result = $this->consumer->sendRequest($this->am_background_image,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * favorites access
	 * 
	 * @access public
	 * @param array		$options	id,page
	 * @return mix		false or xml
	 */
	function getFavorites($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["page"])) $param["page"] = $options["page"];
		
		if(isset($options["id"])) $result = $this->consumer->sendRequest(sprintf($this->fv_index_target, $options["id"]),$param,"GET");
		else $result = $this->consumer->sendRequest($this->fv_index,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * favorites create access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function createFavorites($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->fv_create, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * favorites destroy access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function destroyFavorites($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->fv_destroy, $options["id"]),$param,"DELETE");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * notifications follow access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function setNotifyFollow($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->nm_follow, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * notifications leave access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function setNotifyLeave($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->nm_leave, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * blocks create access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function createBlock($options=false){
		$rtn = false;
		$param = array();

		$result = $this->consumer->sendRequest(sprintf($this->bm_create,$options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * blocks destroy access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function destroyBlock($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->bm_destroy,$options["id"]),$param,"DELETE");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * blocks exists access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function getBlockExists($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->bm_exists,$options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * blocks blocking access
	 * 
	 * @access public
	 * @param array		$options	page
	 * @return mix		false or xml
	 */
	function getBlocking($options=false){
		$rtn = false;
		$param = array();
		if(isset($options["page"])) $param["page"] = $options["page"];
		
		$result = $this->consumer->sendRequest($this->bm_blocking,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * blocks blocking ids access
	 * 
	 * @access public
	 * @return mix		false or xml
	 */
	function getBlockingIds(){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest($this->bm_blocking_ids,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}
	
	/**
	 * report spam access
	 * 
	 * @access public
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function reportSpam($options=false){
		$rtn = false;
		$param = array();
		
		$result = $this->consumer->sendRequest(sprintf($this->rm_spam,$options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
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