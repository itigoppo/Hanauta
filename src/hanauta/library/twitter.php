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
	var $sm_rts = "https://api.twitter.com/1.1/statuses/retweets/%s.json";
	var $sm_show = "https://api.twitter.com/1.1/statuses/show.json";
	var $sm_destroy = "https://api.twitter.com/1.1/statuses/destroy/%s.json";
	var $sm_update = "https://api.twitter.com/1.1/statuses/update.json";
	var $sm_rt = "https://api.twitter.com/1.1/statuses/retweet/%s.json";
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
	 * GET statuses/mentions_timeline
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
	 * GET statuses/user_timeline
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
	 * GET statuses/home_timeline
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
	 * GET statuses/retweets_of_me
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
	 * GET statuses/retweets/:id
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,count,trim_user
	 * @return mix		false or xml
	 */
	function getRetweet($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->sm_rts, $options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET statuses/show/:id
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,trim_user,include_my_retweet,include_entities
	 * @return mix		false or xml
	 */
	function getStatusShow($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];
		if(isset($options["include_my_retweet"])) $param["include_my_retweet"] = $options["include_my_retweet"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->sm_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST statuses/destroy/:id
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,trim_user
	 * @return mix		false or xml
	 */
	function destroyStatus($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->sm_destroy, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST statuses/update
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	status,in_reply_to_status_id,lat,long,place_id,display_coordinates,trim_user
	 * @return mix		false or xml
	 */
	function updateStatus($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["status"])) $param["status"] = $options["status"];
		if(isset($options["in_reply_to_status_id"])) $param["in_reply_to_status_id"] = $options["in_reply_to_status_id"];
		if(isset($options["lat"])) $param["lat"] = $options["lat"];
		if(isset($options["long"])) $param["long"] = $options["long"];
		if(isset($options["place_id"])) $param["place_id"] = $options["place_id"];
		if(isset($options["display_coordinates"])) $param["display_coordinates"] = $options["display_coordinates"];
		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];

		$result = $consumer["consumer"]->sendRequest($this->sm_update,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST statuses/retweet/:id
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,trim_user
	 * @return mix		false or xml
	 */
	function retweetStatus($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["trim_user"])) $param["trim_user"] = $options["trim_user"];

		$result = $consumer["consumer"]->sendRequest(sprintf($this->sm_rt, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET statuses/retweeters/ids
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,cursor,lstringify_ids
	 * @return mix		false or xml
	 */
	function getRetweetIds($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];

		$result = $consumer["consumer"]->sendRequest($this->sm_rt_id,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET search/tweets
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	q,geocode,lang,locale,result_type,count,until,since_id,max_id,include_entities,callback
	 * @return mix		false or xml
	 */
	function getSearch($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["q"])) $param["q"] = $options["q"];
		if(isset($options["geocode"])) $param["geocode"] = $options["geocode"];
		if(isset($options["lang"])) $param["lang"] = $options["lang"];
		if(isset($options["locale"])) $param["locale"] = $options["locale"];
		if(isset($options["result_type"])) $param["result_type"] = $options["result_type"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["until"])) $param["until"] = $options["until"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["callback"])) $param["callback"] = $options["callback"];

		$result = $consumer["consumer"]->sendRequest($this->sh_search,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET direct_messages
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	since_id,max_id,count,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getDM($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->dm_get,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET direct_messages/sent
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	since_id,max_id,count,page,include_entities
	 * @return mix		false or xml
	 */
	function getSentDM($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->dm_sent,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET direct_messages/show
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function getDMShow($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];

		$result = $consumer["consumer"]->sendRequest($this->dm_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST direct_messages/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,include_entities
	 * @return mix		false or xml
	 */
	function destroyDM($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->dm_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST direct_messages/new
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,text
	 * @return mix		false or xml
	 */
	function newDM($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["text"])) $param["text"] = $options["text"];

		$result = $consumer["consumer"]->sendRequest($this->dm_new,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friendships/no_retweets/ids
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	stringify_ids
	 * @return mix		false or xml
	 */
	function getNoRtIds($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];

		$result = $consumer["consumer"]->sendRequest($this->fm_no_rt,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friends/ids
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,cursor,stringify_ids,count
	 * @return mix		false or xml
	 */
	function getFriendsIds($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];
		if(isset($options["count"])) $param["count"] = $options["count"];

		$result = $consumer["consumer"]->sendRequest($this->fm_friend_id,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET followers/ids
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,cursor,stringify_ids,count
	 * @return mix		false or xml
	 */
	function getFollowersIds($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];
		if(isset($options["count"])) $param["count"] = $options["count"];

		$result = $consumer["consumer"]->sendRequest($this->fm_followers_id,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friendships/lookup
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name
	 * @return mix		false or xml
	 */
	function getFriendsLookup($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];

		$result = $consumer["consumer"]->sendRequest($this->fm_lookup,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friendships/incoming
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	cursor,stringify_ids
	 * @return mix		false or xml
	 */
	function getIncoming($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];

		$result = $consumer["consumer"]->sendRequest($this->fm_incoming,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friendships/outgoing
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	cursor,stringify_ids
	 * @return mix		false or xml
	 */
	function getOutgoing($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];

		$result = $consumer["consumer"]->sendRequest($this->fm_outgoing,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST friendships/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id,follow
	 * @return mix		false or xml
	 */
	function createFriend($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["follow"])) $param["follow"] = $options["follow"];

		$result = $consumer["consumer"]->sendRequest($this->fm_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST friendships/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id
	 * @return mix		false or xml
	 */
	function destroyFriend($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];

		$result = $consumer["consumer"]->sendRequest($this->fm_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST friendships/update
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id,device,retweets
	 * @return mix		false or xml
	 */
	function updateFriend($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["device"])) $param["device"] = $options["device"];
		if(isset($options["retweets"])) $param["retweets"] = $options["retweets"];

		$result = $consumer["consumer"]->sendRequest($this->fm_update,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friendships/show
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	source_id,source_screen_name,target_id,target_screen_name
	 * @return mix		false or xml
	 */
	function getFriendShow($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["source_id"])) $param["source_id"] = $options["source_id"];
		if(isset($options["source_screen_name"])) $param["source_screen_name"] = $options["source_screen_name"];
		if(isset($options["target_id"])) $param["target_id"] = $options["target_id"];
		if(isset($options["target_screen_name"])) $param["target_screen_name"] = $options["target_screen_name"];

		$result = $consumer["consumer"]->sendRequest($this->fm_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET friends/list
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,cursor,skip_status,include_user_entities
	 * @return mix		false or xml
	 */
	function getFriends($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];
		if(isset($options["include_user_entities"])) $param["include_user_entities"] = $options["include_user_entities"];

		$result = $consumer["consumer"]->sendRequest($this->fm_friend,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET followers/list
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,cursor,skip_status,include_user_entities
	 * @return mix		false or xml
	 */
	function getFollowers($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];
		if(isset($options["include_user_entities"])) $param["include_user_entities"] = $options["include_user_entities"];

		$result = $consumer["consumer"]->sendRequest($this->fm_followers,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET account/settings
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options
	 * @return mix		false or xml
	 */
	function getSettings($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		$result = $consumer["consumer"]->sendRequest($this->um_setting,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET account/verify_credentials
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getVerify($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->um_verify,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST account/settings
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	trend_location_woeid,sleep_time_enabled,start_sleep_time,end_sleep_time,time_zone,lang
	 * @return mix		false or xml
	 */
	function setSettings($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["trend_location_woeid"])) $param["trend_location_woeid"] = $options["trend_location_woeid"];
		if(isset($options["sleep_time_enabled"])) $param["sleep_time_enabled"] = $options["sleep_time_enabled"];
		if(isset($options["start_sleep_time"])) $param["start_sleep_time"] = $options["start_sleep_time"];
		if(isset($options["end_sleep_time"])) $param["end_sleep_time"] = $options["end_sleep_time"];
		if(isset($options["time_zone"])) $param["time_zone"] = $options["time_zone"];
		if(isset($options["lang"])) $param["skip_status"] = $options["lang"];

		$result = $consumer["consumer"]->sendRequest($this->um_setting,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST account/update_delivery_device
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	device,include_entities
	 * @return mix		false or xml
	 */
	function setDevice($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["device"])) $param["device"] = $options["device"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->um_device,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST account/update_profile
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	name,url,location,description,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function setProfile($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["name"])) $param["name"] = $options["name"];
		if(isset($options["url"])) $param["url"] = $options["url"];
		if(isset($options["location"])) $param["location"] = $options["location"];
		if(isset($options["description"])) $param["description"] = $options["description"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->um_profile,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET blocks/list
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	include_entities,skip_status,cursor
	 * @return mix		false or xml
	 */
	function getBlocks($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];

		$result = $consumer["consumer"]->sendRequest($this->um_blocks,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET blocks/ids
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	stringify_ids,cursor
	 * @return mix		false or xml
	 */
	function getBlocksIds($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["stringify_ids"])) $param["stringify_ids"] = $options["stringify_ids"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];

		$result = $consumer["consumer"]->sendRequest($this->um_blocks_id,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST blocks/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function createBlock($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->um_blocks_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST blocks/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function destroyBlock($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->um_blocks_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET users/lookup
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id,include_entities
	 * @return mix		false or xml
	 */
	function getUsersLookup($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->um_lookup,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET users/show
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,include_entities
	 * @return mix		false or xml
	 */
	function getUsersShow($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->um_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET users/search
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	q,page,count,include_entities
	 * @return mix		false or xml
	 */
	function getUsersSearch($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["q"])) $param["q"] = $options["q"];
		if(isset($options["page"])) $param["page"] = $options["page"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->um_search,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET users/contributees
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getContributees($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->um_contributees,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET users/contributors
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getContributors($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->um_contributors,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET favorites/list
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,count,since_id,max_id,include_entities
	 * @return mix		false or xml
	 */
	function getFavs($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->fv_list,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST favorites/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,include_entities
	 * @return mix		false or xml
	 */
	function destroyFav($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->fv_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST favorites/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,include_entities
	 * @return mix		false or xml
	 */
	function createFav($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];

		$result = $consumer["consumer"]->sendRequest($this->fv_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/list
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,reverse
	 * @return mix		false or xml
	 */
	function getLists($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["reverse"])) $param["reverse"] = $options["reverse"];

		$result = $consumer["consumer"]->sendRequest($this->lm_list,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/statuses
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,owner_screen_name,owner_id,since_id,max_id,count,include_entities,include_rts
	 * @return mix		false or xml
	 */
	function getListTweets($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["since_id"])) $param["since_id"] = $options["since_id"];
		if(isset($options["max_id"])) $param["max_id"] = $options["max_id"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["include_rts"])) $param["include_rts"] = $options["include_rts"];

		$result = $consumer["consumer"]->sendRequest($this->lm_statuses,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/members/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,user_id,screen_name,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function destryListMember($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_members_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/memberships
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,cursor,owner_id,filter_to_owned_lists
	 * @return mix		false or xml
	 */
	function getUserLists($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["filter_to_owned_lists"])) $param["filter_to_owned_lists"] = $options["filter_to_owned_lists"];

		$result = $consumer["consumer"]->sendRequest($this->lm_memberships,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/subscribers
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,owner_screen_name,owner_id,cursor,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getSubscribers($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->lm_subscribers,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/subscribers/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	owner_screen_name,owner_id,list_id,slug
	 * @return mix		false or xml
	 */
	function createSubscribers($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];

		$result = $consumer["consumer"]->sendRequest($this->lm_subscribers_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/subscribers/show
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	owner_screen_name,owner_id,list_id,slug,user_id,screen_name,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getUserSubscribers($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->lm_subscribers_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/subscribers/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function destroySubscribers($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_subscribers_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/members/create_all
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,user_id,screen_name,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function createListAll($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_create_all,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/members/show
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,user_id,owner_screen_name,owner_id,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getUserListMember($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->lm_members_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/members
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,owner_screen_name,owner_id,cursor,include_entities,skip_status
	 * @return mix		false or xml
	 */
	function getListMember($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];
		if(isset($options["include_entities"])) $param["include_entities"] = $options["include_entities"];
		if(isset($options["skip_status"])) $param["skip_status"] = $options["skip_status"];

		$result = $consumer["consumer"]->sendRequest($this->lm_members,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/members/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,user_id,screen_name,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function createListMember($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_members_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/destroy
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	owner_screen_name,owner_id,list_id,slug
	 * @return mix		false or xml
	 */
	function destroyList($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];
		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];

		$result = $consumer["consumer"]->sendRequest($this->lm_destroy,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/update
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,name,mode,description,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function updateList($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["name"])) $param["name"] = $options["name"];
		if(isset($options["mode"])) $param["mode"] = $options["mode"];
		if(isset($options["description"])) $param["description"] = $options["description"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_update,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	name,mode,description
	 * @return mix		false or xml
	 */
	function createList($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["name"])) $param["name"] = $options["name"];
		if(isset($options["mode"])) $param["mode"] = $options["mode"];
		if(isset($options["description"])) $param["description"] = $options["description"];

		$result = $consumer["consumer"]->sendRequest($this->lm_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/update
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function getListShow($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_show,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/subscriptions
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,count,cursor
	 * @return mix		false or xml
	 */
	function getSubscriptions($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];

		$result = $consumer["consumer"]->sendRequest($this->lm_subscriptions,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST lists/members/destroy_all
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	list_id,slug,user_id,screen_name,owner_screen_name,owner_id
	 * @return mix		false or xml
	 */
	function destroyListAll($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["list_id"])) $param["list_id"] = $options["list_id"];
		if(isset($options["slug"])) $param["slug"] = $options["slug"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["owner_screen_name"])) $param["owner_screen_name"] = $options["owner_screen_name"];
		if(isset($options["owner_id"])) $param["owner_id"] = $options["owner_id"];

		$result = $consumer["consumer"]->sendRequest($this->lm_destroy_all,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET lists/ownerships
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	user_id,screen_name,count,cursor
	 * @return mix		false or xml
	 */
	function getOwnerships($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];
		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["count"])) $param["count"] = $options["count"];
		if(isset($options["cursor"])) $param["cursor"] = $options["cursor"];

		$result = $consumer["consumer"]->sendRequest($this->lm_ownerships,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET saved_searches/list
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options
	 * @return mix		false or xml
	 */
	function getSavedSearch($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		$result = $consumer["consumer"]->sendRequest($this->sh_saved_list,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET saved_searches/show/:id
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function getSavedSearchId($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		$result = $consumer["consumer"]->sendRequest(sprintf($this->sh_saved_show, $options["id"]),$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST saved_searches/create
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	query
	 * @return mix		false or xml
	 */
	function createSavedSearch($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["query"])) $param["query"] = $options["query"];

		$result = $consumer["consumer"]->sendRequest($this->sh_saved_create,$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST saved_searches/destroy/:id
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id
	 * @return mix		false or xml
	 */
	function destroySavedSearch($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		$result = $consumer["consumer"]->sendRequest(sprintf($this->sh_saved_destroy, $options["id"]),$param,"POST");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET trends/place
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	id,exclude
	 * @return mix		false or xml
	 */
	function getTrends($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["id"])) $param["id"] = $options["id"];
		if(isset($options["exclude"])) $param["exclude"] = $options["exclude"];

		$result = $consumer["consumer"]->sendRequest($this->tr_place,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET trends/available
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options
	 * @return mix		false or xml
	 */
	function getTrendsAvailable($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		$result = $consumer["consumer"]->sendRequest($this->tr_available,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * GET trends/closest
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	lat,long
	 * @return mix		false or xml
	 */
	function getTrendsClosest($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["lat"])) $param["lat"] = $options["lat"];
		if(isset($options["long"])) $param["long"] = $options["long"];

		$result = $consumer["consumer"]->sendRequest($this->tr_closest,$param,"GET");
		$rtn = $this->_getBody($result);
		return $rtn;
	}

	/**
	 * POST users/report_spam
	 *
	 * @access public
	 * @param array		$consumer	オブジェクト等(type,consumer,regist)
	 * @param array		$options	screen_name,user_id
	 * @return mix		false or xml
	 */
	function reportSpam($consumer,$options=false){
		if($consumer["type"] != "obj") return false;
		$rtn = false;
		$param = array();

		if(isset($options["screen_name"])) $param["screen_name"] = $options["screen_name"];
		if(isset($options["user_id"])) $param["user_id"] = $options["user_id"];

		$result = $consumer["consumer"]->sendRequest($this->sr_spam,$param,"POST");
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
			$consumer->setToken($token["access_token"]);
			$consumer->setTokenSecret($token["access_token_secret"]);
			$rtn = $consumer;
		}else{
			// 未認証
			if(isset($Hanauta->_svars["token"]["flg"]) && $Hanauta->_svars["token"]["flg"] == "start" && isset($Hanauta->_gvars["oauth_token"])){
				// callback
				$verifier = $Hanauta->_gvars["oauth_verifier"];
				$consumer->setToken($Hanauta->_svars["token"]["request_token"]);
				$consumer->setTokenSecret($Hanauta->_svars["token"]["request_token_secret"]);
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