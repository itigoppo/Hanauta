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
if(isset($Hanauta->_gvars["login_id"])) $Hanauta->obj["request"]->del_ses($Hanauta->_svars,array());


$Hanauta->obj_ext["test"]->test();





/**
 *	テンプレート
 */
// テンプレート用変数設定


// 処理時間計測終了
$obj["benchmark"]->end();


print $obj["benchmark"]->score;

?>