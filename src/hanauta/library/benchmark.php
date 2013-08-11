<?php
/**
 * benchmark.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 11/12/09 last update
 * @copyright http://www.nono150.com/
 */

/**
 * 処理時間計測クラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class benchmark{

	//
	var $start;
	var $end;
	var $score;

	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * 現在時刻をマイクロ秒単位で取得
	 *
	 * @access public
	 * @return int		開始時間
	 */
	function now(){
		list($msec,$sec) = explode(" ",microtime());
		$data = (float) $msec + (float) $sec;
		$rtn = $data;
		return $rtn;
	}

	/**
	 * 開始
	 *
	 * @access public
	 */
	function start(){
		$data = $this->now();
		$this->start = $data;
	}

	/**
	 * 終了
	 *
	 * @access public
	 */
	function end(){
		$data = $this->now();
		$this->end = $data;
		// スコア計算
		$this->score = round($this->end - $this->start,5);
	}
}
?>
