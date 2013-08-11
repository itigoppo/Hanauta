<?php
/**
 * error.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 07/06/25 last update
 * @copyright http://www.nono150.com/
 */

/**
 * エラーチェッククラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class error extends string{
	/**
	 * コンストラクタ
	 */
	function __construct(){
		$this->string();
	}

	/**
	 * NULL判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @return bool	true：不正、false：正しい
	 */
	function check_null($str){
		$str = trim($str);
		if(!isset($str)) return true;
		if($str == NULL) return true;
		return false;
	}

	/**
	 * 半角判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 *								書式：最大文字数:最小文字数<>チェックタイプ で固定
	 *								チェックタイプ
	 *								+ num : 半角数字
	 *								+ alp : 半角英字
	 *								+ alpnum : 半角英数字
	 *								+ mix : 半角英数字記号
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ 1003		->	引数エラー
	 *					+ 1004		->	文字数オーバー
	 *					+ 1005		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_han_str($str,$null_flg,$param=NULL){
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		if(!$this->check_null($param)){
			$param = explode("<>", $param);
			if(strstr($param[0],":")){
				list($max,$min) = explode(":", $param[0]);
			}else{
				$max = $param[0];
			}
			if(!isset($min)) $min = 0;
			if($max != 0){
				if($this->check_null($min)) $min = 0;
				$error = $this->check_len_str($str,$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
			}
		}
		if($param[1] == "num") $pattern = "/^[0-9]+$/";
		if($param[1] == "int") $pattern = "/^-?[0-9]+$/";
		if($param[1] == "alp") $pattern = "/^[a-zA-Z]+$/";
		if($param[1] == "alpnum") $pattern = "/^[0-9a-zA-Z]+$/";
		if($param[1] == "mix") $pattern = "/^[0-9a-zA-Z!\"#\$%&\'\(\)=\-~\^|\\\`@{\[\+;\*:}\]<,>\.\?\/_\n\r\t\s]+$/";
		if(!preg_match($pattern, $str)) return 1002;
		return false;
	}

	/**
	 * 小数点判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 *								書式：最大文字数:最小文字数<>整数部分上限桁数<>少数部分上限桁数 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ 1003		->	引数エラー
	 *					+ 1004		->	文字数オーバー
	 *					+ 1005		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_float($str,$null_flg,$param=NULL){
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		if(!$this->check_null($param)){
			$param = explode("<>", $param);
			list($max,$min) = explode(":", $param[0]);
			if($max != 0){
				if($this->check_null($min)) $min = 0;
				$error = $this->check_len_str($str,$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
			}
		}
		$str_arr = explode(".", $str);
		if(count($str_arr) > 2) return 1002;
		if($this->check_han_str($str_arr[0],0,"<>num")) return 1002;
		if(count($str_arr) > 1){
			if($this->check_han_str($str_arr[1],0,"<>num")) return 1002;
			// 小数点以下桁数オーバー
			if(strlen($str_arr[1]) > $param[2]) return 1002;
			if(strlen($str_arr[0]) == 0) return 1002;
		}
		// 整数部分桁数オーバー
		if(strlen($str_arr[0]) > $param[1]) return 1002;
		return false;
	}

	/**
	 * 同値判定
	 *
	 * @access public
	 * @param array		$str		文字配列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 *								書式：最大文字数:最小文字数 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ 1003		->	引数エラー
	 *					+ 1004		->	文字数オーバー
	 *					+ 1005		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_same($str_arr,$null_flg,$param=NULL){
		if($null_flg && $this->check_null($str_arr[0])) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		if(!$this->check_null($param)){
			$param = explode("<>", $param);
			list($max,$min) = explode(":", $param[0]);
			if($max != 0){
				if($this->check_null($min)) $min = 0;
				$error = $this->check_len_str($str_arr[0],$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
				$error = $this->check_len_str($str_arr[1],$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
			}
		}
		if($str_arr[0] != $str_arr[1]) return 1002;
		return false;
	}

	/**
	 * 全角カナ判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 *								書式：最大文字数:最小文字数 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ 1003		->	引数エラー
	 *					+ 1004		->	文字数オーバー
	 *					+ 1005		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_kana($str,$null_flg,$param=NULL){
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		// 文字数判定
		if(!$this->check_null($param)){
			$param = explode("<>", $param);
			list($max,$min) = explode(":", $param[0]);
			if($max != 0){
				if($this->check_null($min)) $min = 0;
				$error = $this->check_len_str($str,$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
			}
		}
		//(?:\xA5[\xA1-\xF6])
		$str = $this->convart_charset($str,"UTF-8");
		$pattern = "/^(\xe3(\x82|\x83)[\x80-\xbf])+$/";
		if(!preg_match($pattern, $str)) return 1002;

		return false;
	}

	/**
	 * メールアドレス判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 *								書式：最大文字数:最小文字数 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ 1003		->	引数エラー
	 *					+ 1004		->	文字数オーバー
	 *					+ 1005		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_mail($str,$null_flg,$param=NULL){
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		// 文字数判定
		if(!$this->check_null($param)){
			$param = explode("<>", $param);
			list($max,$min) = explode(":", $param[0]);
			if($max != 0){
				if($this->check_null($min)) $min = 0;
				$error = $this->check_len_str($str,$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
			}
		}
		$pattern = "/^[a-zA-Z0-9\"\._\?\+\/-]+\@[a-zA-Z0-9\-_]+.[a-zA-Z0-9\-_.]+$/";
		if(!preg_match($pattern, $str)) return 1002;
		return false;
	}

	/**
	 * URL判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 *								書式：最大文字数:最小文字数 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ 1003		->	引数エラー
	 *					+ 1004		->	文字数オーバー
	 *					+ 1005		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_url($str,$null_flg,$param=NULL){
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		// 文字数判定
		if(!$this->check_null($param)){
			$param = explode("<>", $param);
			list($max,$min) = explode(":", $param[0]);
			if($max != 0){
				if($this->check_null($min)) $min = 0;
				$error = $this->check_len_str($str,$null_flg,$max,$min);
				if($error == 1001) return 1001;
				if($error == 1002) return 1003;
				if($error == 1003) return 1004;
				if($error == 1004) return 1005;
			}
		}
		$pattern = "/^https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+$/";
		if(!preg_match($pattern, $str)) return 1002;
		return false;
	}

	/**
	 * 郵便番号判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター（判定部分は、0:未使用、1:使用
	 *								書式：0<>ハイフン有判定:7桁判定 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ false		->	正しい
	 */
	function check_zip($str,$null_flg,$param=NULL){
		$rtn = NULL;
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		$param = explode("<>", $param);
		list($hyphen_flg,$nohyphen_flg) = explode(":", $param[1]);
		// デフォルト指定
		if($this->check_null($hyphen_flg)) $hyphen_flg = 0;
		if($this->check_null($nohyphen_flg)) $nohyphen_flg = 0;
		if(!$hyphen_flg && !$nohyphen_flg) $hyphen_flg = 1;

		// 形式：xxx-xxxx
		$pattern = "/^\d{3}\-\d{4}$/";
		if($hyphen_flg && preg_match($pattern, $str)) $rtn = false;
		else $rtn = 1002;
		if(!$nohyphen_flg || !$rtn) return $rtn;

		// 形式：xxxxxxx
		$pattern = "/\d{7}/";
		if($nohyphen_flg && preg_match($pattern, $str)) $rtn = false;
		else $rtn = 1002;
		return $rtn;
	}

	/**
	 * 電話番号判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター（判定部分は、0:未使用、1:使用
	 *								書式：0<>チェックタイプ<>ハイフン有判定:括弧判定:桁数固定判定 で固定
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	不正
	 *					+ false		->	正しい
	 */
	function check_tel($str,$null_flg,$param=NULL){
		$rtn = NULL;
		if($null_flg && $this->check_null($str)) return 1001;
		if(!$null_flg && $this->check_null($str)) return false;
		$param = explode("<>", $param);
		list($hyphen_flg,$pare_flg,$fix_flg) = explode(":", $param[2]);
		// デフォルト指定
		if($this->check_null($hyphen_flg)) $hyphen_flg = 0;
		if($this->check_null($pare_flg)) $pare_flg = 0;
		if($this->check_null($fix_flg)) $fix_flg = 0;
		if(!$hyphen_flg && !$pare_flg && !$fix_flg) $hyphen_flg = 1;

		// 形式：xx-xxx-xxxx
		if($param[1] == "tel") $pattern = "/^\d{2,5}\-\d{1,5}\-\d{4}$/";
		if($param[1] == "mb") $pattern = "/^\d{3}\-\d{4}\-\d{4}$/";
		if($param[1] == "free") $pattern = "/^\d{4}\-\d{3}\-\d{3}$/";
		if($hyphen_flg && preg_match($pattern, $str)) $rtn = false;
		else $rtn = 1002;
		if(!$nohyphen_flg || !$rtn) return $rtn;

		// 形式：xx-xxx-xxxx
		if($param[1] == "tel") $pattern = "/^\d{2,5}\(\d{1,5}\)\d{4}$/";
		if($param[1] == "mb") $pattern = "/^\d{3}\(\d{4}\)\d{4}$/";
		if($param[1] == "free") $pattern = "/^\d{4}\(\d{3}\)\d{3}$/";
		if($pare_flg && preg_match($pattern, $str)) $rtn = false;
		else $rtn = 1002;
		if(!$pare_flg || !$rtn) return $rtn;

		// 形式：xxxxxxx
		if($param[1] == "tel") $pattern = "/\d{7,14}/";
		if($param[1] == "mb") $pattern = "/\d{11}/";
		if($param[1] == "free") $pattern = "/\d{10}/";
		if($fix_flg && preg_match($pattern, $str)) $rtn = false;
		else $rtn = 1002;
		return $rtn;
	}

	/**
	 * 日付妥当性判定
	 *
	 * @access public
	 * @param array		$str_arr	日付配列（[0]:yyyy、[1]:mm、[2]:dd
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param string	$param		パラメーター
	 * @return string	結果
	 *					+ 1001		->	年空白
	 *					+ 1002		->	月空白
	 *					+ 1003		->	日空白
	 *					+ 1004		->	不正
	 *					+ false		->	正しい
	 */
	function check_date($str_arr,$null_flg,$param=NULL){
		$rtn = NULL;
		if(!is_array($str_arr)) return 1004;
		if($null_flg && $this->check_null($str_arr[0])) return 1001;
		if($null_flg && $this->check_null($str_arr[1])) return 1002;
		if($null_flg && $this->check_null($str_arr[2])) return 1003;
		if(!checkdate($str_arr[1],$str_arr[2],$str_arr[0])) return 1004;
		return false;
	}

	/**
	 * バイト数判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param int		$max		最大バイト数
	 * @param int		$min		最小バイト数
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	引数エラー
	 *					+ 1003		->	バイト数オーバー
	 *					+ 1004		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_len_byte($str,$null_flg,$max,$min=0){
		if($null_flg && $this->check_null($str)) return 1001;
		if($null_flg && $this->check_null($max)) return 1002;
		if($this->check_han_str($max,0,"<>num")) return 1002;
		if($this->check_han_str($min,0,"<>num")) return 1002;
		if(strlen($str) > $max) return 1003;
		if($min > 0 && strlen($str) < $min) return 1004;
		return false;
	}

	/**
	 * 文字数判定
	 *
	 * @access public
	 * @param string	$str		文字列
	 * @param int		$null_flg	NULL判定（0:未使用、1:使用
	 * @param int		$max		最大文字数
	 * @param int		$min		最小文字数
	 * @return string	結果
	 *					+ 1001		->	空白
	 *					+ 1002		->	引数エラー
	 *					+ 1003		->	文字数オーバー
	 *					+ 1004		->	最小値未満
	 *					+ false		->	正しい
	 */
	function check_len_str($str,$null_flg,$max,$min=0){
		if($null_flg && $this->check_null($str)) return 1001;
		if($null_flg && $this->check_null($max)) return 1002;
		if($this->check_han_str($max,0,"<>num")) return 1002;
		if($this->check_han_str($min,0,"<>num")) return 1002;
		if(mb_strlen($str) > $max) return 1003;
		if($min > 0 && mb_strlen($str) < $min) return 1004;
		return false;
	}
}
?>
