<?php
/**
 * index.php
 *
 * @author	HisatoS.
 * @package Example
 * @version 13/08/13 last update
 * @copyright http://www.nono150.com/
 */

// 設定ファイル
require_once("./config.php");

// 共通処理ファイル
require_once("./common.php");

/**
 * 変数設定
 */


/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

// セッション削除
$Hanauta->obj["request"]->del_ses($Hanauta->_svars,array("auth"));
if(isset($Hanauta->_gvars["logout"])) $Hanauta->obj["request"]->del_ses($Hanauta->_svars,array());



// 仮データ
$Hanauta->_pvars["submit"] = "1";
$Hanauta->_pvars["login_id"] = "itigoppo";
$Hanauta->_pvars["login_pass"] = "1333";

//$Hanauta->_pvars["login_id"] = "hanauta";
//$Hanauta->_pvars["login_pass"] = "1111";
$Hanauta->_pvars["keyword"] = "@itigoppo ぱんつさんぱんだください。";

// Twitter認証
$login_data = $Hanauta->obj_ext["login"]->twitter();

if($login_data["type"] == "obj"){
	// 最終ログイン時間
	$last_login = $Hanauta->obj_ext["login"]->set_last_login($login_data["user"]["id"]);
	$Hanauta->obj_ext["test"]->test();

}



//$Hanauta->obj["ponpon"]->pr($Hanauta);
//$Hanauta->obj["ponpon"]->pr($login_data);

/**
 *	テンプレート
 */
// テンプレート用変数設定


// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();


print $Hanauta->obj["benchmark"]->score;

?>