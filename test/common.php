<?php
/**
 * common.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/06 last update
 * @copyright http://www.nono150.com/
 */

/**
 * ライブラリ関連
 */
// フレームワーク起動
$dir_fw = constant("DIR_FW");
require_once($dir_fw."Hanauta.php");
$Hanauta = new Hanauta($dir_fw);
// 処理時間計測開始
$Hanauta->obj["benchmark"]->start();
/*
// Smarty起動
$dir_smarty = constant("DIR_SMARTY");
require_once($dir_smarty."Smarty.class.php");
$smarty = new Smarty();
$smarty->template_dir = constant("DIR_SMARTY_TMPL")."/".$Hanauta->carrier;
$smarty->compile_dir = constant("DIR_SMARTY_COMPILE");
$smarty->cache_dir = constant("DIR_SMARTY_CACHE");
*/

/**
 * 外部ライブラリ読み込み
 */


/**
 * 変数設定
 */
// リクエストデータ取得
if(isset($Hanauta->_gvars["mode"])) $mode = $Hanauta->_gvars["mode"];
elseif(isset($Hanauta->_pvars["mode"])) $mode = $Hanauta->_pvars["mode"];
if(!isset($mode)) $mode = NULL;
if(isset($Hanauta->_gvars["func"])) $func = $Hanauta->_gvars["func"];
elseif(isset($Hanauta->_pvars["func"])) $func = $Hanauta->_pvars["func"];
if(!isset($func)) $func = NULL;
if(isset($Hanauta->_gvars["view"])) $view = $Hanauta->_gvars["view"];
elseif(isset($Hanauta->_pvars["view"])) $view = $Hanauta->_pvars["view"];
if(!isset($view)) $view = NULL;
if(isset($Hanauta->_gvars["page"])) $page = $Hanauta->_gvars["page"];
elseif(isset($Hanauta->_pvars["page"])) $page = $Hanauta->_pvars["page"];
if(!isset($page)) $page = 1;

// 共通変数
$site_title = constant("SITE_TITLE");
$site_url = constant("SITE_URL");
$script_file = constant("SCRIPT_NAME");
$fw_name = constant("FW_NAME");
$fw_ver = constant("FW_VER");
$fw_url = constant("FW_URL");
$script_name = constant("SCR_NAME");
$script_ver = constant("SCR_VER");
$script_url = constant("SCR_URL");
$script_name_org = constant("SCR_NAME_ORG");
$script_ver_org = constant("SCR_VER_ORG");
$script_url_org = constant("SCR_URL_ORG");
$sid = htmlspecialchars(SID);
$sid = session_name()."=".session_id();

/**
 *	テンプレート
 */
// テンプレート用変数設定
/* Smarty用使うならコメント解除
$smarty->assign("site_title",$site_title);
$smarty->assign("site_url",$site_url);
$smarty->assign("script_file",$script_file);
$smarty->assign("page_title",(isset($page_title)) ? $page_title : $site_title);

$smarty->assign("fw_name",$fw_name);
$smarty->assign("fw_ver",$fw_ver);
$smarty->assign("fw_url",$fw_url);
$smarty->assign("script_name",$script_name);
$smarty->assign("script_ver",$script_ver);
$smarty->assign("script_url",$script_url);
$smarty->assign("script_name_org",$script_name_org);
$smarty->assign("script_ver_org",$script_ver_org);
$smarty->assign("script_url_org",$script_url_org);
*/
?>