<?php
/**
 * index.php
 *
 * @author	HisatoS.
 * @package Example
 * @version 14/02/08 last update
 * @copyright http://www.nono150.com/
 */

// 設定ファイル
require_once("./config.php");

// 共通処理ファイル
require_once("./common.php");

/**
 * 変数設定
*/
// テンプレートファイル名
$tmp_file = "index.tpl";

// ページ用各変数初期化

/**
 * 処理開始
 */
// ヘッダ出力
$heder_xml = constant("CONTENT_TYPE_XML");
$heder_html = constant("CONTENT_TYPE_HTML");
if($mode == "rss") header($heder_xml);
else header($heder_html);

// 住所分割
$addr = $Hanauta->obj["address"]->explode_address("東京都港区赤坂9-7-1ミッドタウン・タワー");

// 住所出力
$Hanauta->obj["ponpon"]->pr($addr);

// 処理時間計測終了
$Hanauta->obj["benchmark"]->end();

print $Hanauta->obj["benchmark"]->score;