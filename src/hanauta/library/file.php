<?php
/**
 * file.php
 *
 * @author	HisatoS.
 * @package Hanauta
 * @version 10/01/30 last update
 * @copyright http://www.nono150.com/
 */

/**
 * ファイル取り扱い関連クラス
 *
 * @author HisatoS.
 * @access public
 * @package Hanauta
 */

class file{
	/**
	 * コンストラクタ
	 */
	function __construct(){
	}

	/**
	 * ディレクトリファイル掃除
	 *
	 * @access public
	 * @param string	$del_time	削除期間（秒指定）
	 * @param string	$dir		削除場所
	 * @param boolean 	$parent		親ディレクトリ
	 */
	function clean_dir($del_time,$dir,$parent=true) {
		if(!$del_time || !$dir) return;
		$time_zone = constant("TIME_ZONE");
		$del_flg = false;
		$file_flg = false;

		if($handle = opendir("$dir")){
			while(false !== ($item = readdir($handle))){
				if($item != "." && $item != ".."){
					if(is_dir("$dir/$item")) {
						$del_flg = false;
						$file_flg = true;
						$this->clean_dir($del_time,"$dir/$item",false);
					}else{
						$file_flg = true;
						$filetime = filemtime("$dir/$item") + $time_zone;
						$deltime = (time() - $del_time) + $time_zone;
						if($filetime > $deltime) continue;
						unlink("$dir/$item");
						$del_flg = true;
						$file_flg = false;
					}
				}
			}
			if($item === false && !$file_flg && !$parent) $del_flg = true;
			closedir($handle);
			if($del_flg) rmdir($dir);
		}
	}

	/**
	 * FTPアップロード
	 *
	 * @access public
	 * @param array		$ftp		FTP情報
	 * @param string	$remote_fileアップ場所
	 * @param string 	$local_file	ローカルファイル
	 */
	function ftp_upload($ftp,$remote_file,$local_file){
		// 接続を確率
		$f_conn = ftp_connect($ftp["server"]);
		// ﾛｸﾞｲﾝ
		$login_result = ftp_login($f_conn, $ftp["id"], $ftp["pass"]);
		// PASV
		if(isset($ftp["pasv"]) && $ftp["pasv"]) ftp_pasv($f_conn, true);
		// ファイルアップロード
		if(!ftp_put($f_conn,$remote_file,$local_file,FTP_BINARY)){
			print "There was a problem while uploading $file\n";
			exit;
		}
		// 接続解除
		ftp_close($f_conn);
	}
}
?>
