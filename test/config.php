<?php
/**
 * config.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/05 last update
 * @copyright http://www.nono150.com/
 */

/**
 *	エラー表示
 */
//error_reporting(E_ALL);
error_reporting(E_ALL|E_STRICT);
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
//ini_set("include_path", ".:/opt/local/lib/php");

/**
 *	全体設定
 */
// ルートパス
define("DIR_ROOT",$_SERVER["DOCUMENT_ROOT"]."/99.jack/hanauta/");

// ライブラリディレクトリ
define("DIR_LIB", constant("DIR_ROOT")."libs/");

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

/**
 *	フレームワーク設定
 */
// フレームワークディレクトリ
define("DIR_FW", constant("DIR_LIB")."hanauta/");

// フレームワーク設定ファイル
define("INI_FW",constant("DIR_CNF")."fw.ini");

?>
