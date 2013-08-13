<?php
/**
 * config.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 13/08/13 last update
 * @copyright http://www.nono150.com/
 */

/**
 *	エラー表示
 */
error_reporting(E_ALL);
ini_set("display_errors",true);
if(error_reporting() > 6143) error_reporting(E_ALL ^ E_DEPRECATED);

/**
 *	セッション表示
 */
ini_set("session.name","HanautaSID");
ini_set("session.use_trans_sid",true);

/**
 *	PEARパス設定
 */
//ini_set("include_path", ".:/home/itigoppo/pear/php");

/**
 *	全体設定
 */
// ルートパス
define("DIR_ROOT",$_SERVER["DOCUMENT_ROOT"]."/");

// ライブラリディレクトリ
define("DIR_LIB", constant("DIR_ROOT")."src/");

/**
 * システム設定
 */
// プロジェクトディレクトリ
define("DIR_PRJ", dirname(__FILE__)."/");

// システムディレクトリ
define("DIR_SYS", constant("DIR_PRJ")."sys/");

// 各種設定ファイルディレクトリ
define("DIR_CNF",constant("DIR_PRJ")."conf/");

// プロジェクト設定ファイル
define("INI_SYS", constant("DIR_CNF")."sys.ini");

// エラーログ格納ディレクトリ
define("D_DIR_ERRLOG", constant("DIR_PRJ")."tmp/error/");

/**
 *	フレームワーク設定
 */
// フレームワークディレクトリ
define("DIR_FW", constant("DIR_LIB")."hanauta/");

// フレームワーク設定ファイル
define("INI_FW",constant("DIR_CNF")."fw.ini");

/**
 *	Smarty設定
 */
/* 使うならコメント解除
// Smartyディレクトリ
define("DIR_SMARTY", constant("DIR_LIB")."smarty/");

// テンプレートディレクトリ
define("DIR_SMARTY_TMPL",constant("DIR_PRJ")."templates");

// コンパイルディレクトリ
define("DIR_SMARTY_COMPILE",constant("DIR_PRJ")."tmp/templates_c");

// キャッシュディレクトリ
define("DIR_SMARTY_CACHE",constant("DIR_PRJ")."tmp/cache");
*/

/**
 *	えとせとら
 */
// システム設定ファイル
$ini_sys = constant("INI_SYS");
$sys_arr = parse_ini_file($ini_sys);

// サイトタイトル
define("SITE_TITLE", $sys_arr["SITE_TITLE"]);

// サイトRL
define("SITE_URL", $sys_arr["SITE_URL"]);

// 文字コード - 変えるんなら全ファイルの文字コードを変えること！
define("SITE_CHARSET", $sys_arr["SITE_CHARSET"]);

// ヘッダー出力用 - 弄らなくても大丈夫
define("CONTENT_TYPE_HTML","Content-Type: text/html; charset=".constant("SITE_CHARSET"));
define("CONTENT_TYPE_XML","Content-Type: application/xml; charset=".constant("SITE_CHARSET"));

// $_SERVER が拾えないサーバーの場合は以下のような設定を入れてください。
// $_SERVER["SCRIPT_NAME"] = "/board/index.php";

// タイムゾーン - 変えるんならsys.iniの方を触ること！
define('TIME_ZONE', $sys_arr["TIME_ZONE"] * 3600);
ini_set("date.timezone", $sys_arr["TIME_ZONE_STR"]);

?>