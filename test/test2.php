<?php

mb_language("Japanese");
print "=".replace_text("11á@1","Ç†");

print "#test@@@";

	function replace_text($str,$chg_str=NULL){
		$flag = false;
		$rtn = false;
		$str2 = NULL;
		
		$str = mb_convert_encoding($str,"SJIS-win","auto");
		
		print $str."<hr />";

	    // 13ãÊ 0x8740Å`0x879F
		// NEC-IBMägí£ 0xED40Å`0xEEFC
		// IBMägí£ 0xFA40Å`0xFC4B
		// äOéö 0xF040Å`F9FC
		// Macã@éÌàÀë∂ï∂éö 0x8540Å`0x889E
		// MacäOéöÇ®ÇÊÇ—ècëgóp 0xEAA5Å`0xFCFC
		$pattern = "/(?:[\x87][\x40-\x9F]|[\xED-\xEE][\x40-\xFF]|[\xFA-\xFB][\x40-\xFF]|[\xFC][\x40-\x4B]|[\xF0-\xF9][\x40-\xFF]|[\x85-\x88][\x40-\x9E]|[\xEA-\xFC][\xA5-\xFC])/";

		for($cnt1=0; $cnt1<mb_strlen($str); $cnt1++){
			$bit = mb_substr($str,$cnt1,1);
			//$bit = intval(bin2hex($bit), 16);
		print $str."#".$bit."<hr />";
		    if(preg_match($pattern,$bit,$matches,PREG_OFFSET_CAPTURE)) $flag = true;
print "<pre>";
print_r($matches);
print "</pre><hr />";
			$bit = preg_replace($pattern,$chg_str,$bit);
		//	$bit = pack("H*",bin2hex($bit));
			$str2 .= $bit;
		}
		//$str2 = mb_convert_encoding($str2,"UTF-8","auto");

		if($flag) $rtn = $str2;
		 $rtn = $str2;
		return $rtn;
	}
?>