<?php
/**
 * navigation.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/09 last update
 * @copyright http://www.nono150.com/
 */

/**
 * リンクナビゲーションクラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class navigation{
	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * ページナビゲーション
	 *
	 * @access public
	 * @param int		$page		現在値
	 * @param int		$total_cnt	記事総数
	 * @param int		$page_max	1ページ表示数
	 * @param string	$show_page	ページ表示数
	 * @param int		$link		リンク名
	 * @return string	表示データ
	 */
	function page_navi($page,$total_cnt,$page_max,$show_page,$link){
		// 各変数初期化
		$rtn = NULL;
		$navi = NULL;

		// ページ総数算出
		$total_page = (int) ceil($total_cnt/$page_max);

		// 前後のページ数算出
		$show_page_minus_1 = $show_page - 1;
		$half_page_start = floor($show_page_minus_1/2);
		$half_page_end = ceil($show_page_minus_1/2);

		// ループ値算出
		$start_page = $page - $half_page_start;
		if($start_page <= 0) $start_page = 1;
		$end_page = $page + $half_page_end;
		if(($end_page - $start_page) != $show_page_minus_1) $end_page = $start_page + $show_page_minus_1;

		if($end_page > $total_page){
			$start_page = $total_page - $show_page_minus_1;
			$end_page = $total_page;
		}
		if($start_page <= 0) $start_page = 1;

		// 表記部分
		$navi = "<div class=\"hu-pagenavi\">\n";
		$navi .= "<span class=\"pages\">Page ".$page." of ".$total_page."</span>\n";
		if($page != 1) $navi .= "<a href=\"".$link."1\" title=\"First\">&laquo; First</a>";
		if($page >= $show_page_minus_1 && $show_page < $total_page) $navi .= "<span class\"extend\">...</span>";
		if($page == 1) $navi .= "<span class=\"disabled\">&laquo;</span>";
		else $navi .= "<a href=\"".$link.($page - 1)."\">&laquo;</a>";

		for($cnt1=$start_page; $cnt1<=$end_page; $cnt1++){
			if($cnt1 == $page) $navi .= "<span class=\"current\">".$cnt1."</span>";
			else $navi .= "<a href=\"".$link.$cnt1."\" title=\"".$cnt1."\">".$cnt1."</a>";
		}
		if($page == $total_page) $navi .= "<span class=\"disabled\">&raquo;</span>";
		else $navi .= "<a href=\"".$link.($page + 1)."\">&raquo;</a>";
		if($end_page < $total_page) $navi .= "<span class\"extend\">...</span>";
		if($page != $total_page) $navi .= "<a href=\"".$link.$total_page."\" title=\"Last\">Last &raquo;</a>";
		$navi .= "</div>\n";

		if($total_page <= 1) $navi = NULL;

		$rtn = $navi;
		return $rtn;
	}
}
?>
