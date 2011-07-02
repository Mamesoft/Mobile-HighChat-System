<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Mobile HighChat System for JPhone</title>
</head>
<body>
<?php
//設定項目
$urlp = "http://chat.mamesoft.jp/chat.php";					//chat.phpのURL
$refurl = "http://chat.mamesoft.jp/";						//リファラ
$ip = getenv("REMOTE_ADDR");
$UA = "MHS/1.1 (MobileHighChatSystem.PHP) for JPhone [ip/$ip]";	//UserAgent
//設定項目ここまで


$mode = $_POST["mode"];
$sid = $_POST["sid"];

header( 'Expires: Mon, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

//メイン処理
if ($mode == "ref"){
	$ch=curl_init();
	curl_setopt ($ch,CURLOPT_URL,$urlp);
	curl_setopt ($ch,CURLOPT_POST,1);

	//postするデータ
	$post = "sessionid=$sid";

	curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_REFERER,$refurl);
	curl_setopt ($ch,CURLOPT_USERAGENT,$UA);

	$res = curl_exec($ch);
	curl_close ($ch);
	
	$mydata = json_decode($res);
	$myiddata = $mydata->{'myid'};
	if ($myiddata==""){
	print "<h1>タイムアウト</h1>\n";
	print "一定時間リロード処理を行わなかったため自動退室になりました。\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='チャットトップへ'>\n";
	return;
	}
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='text' name='com'>\n";
	print "<input type='hidden' name='mode' value='com'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='発言'>\n";
	print "</form>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='mode' value='logout'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='退室'>\n";
	print "</form>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='mode' value='ref'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='リロード'>\n";
	print "</form>\n";
}elseif ($mode == "login"){
	$name = $_POST["name"];
	$ch=curl_init();
	curl_setopt ($ch,CURLOPT_URL,$urlp);
	curl_setopt ($ch,CURLOPT_POST,1);

	//postするデータ
	$post = "login=$name&sessionid=$sid&mhs=true";

	curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_REFERER,$refurl);
	curl_setopt ($ch,CURLOPT_USERAGENT,$UA);

	$res = curl_exec($ch);
	curl_close ($ch);
	
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='text' name='com'>\n";
	print "<input type='hidden' name='mode' value='com'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='発言'>\n";
	print "</form>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='mode' value='logout'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='退室'>\n";
	print "</form>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='mode' value='ref'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='リロード'>\n";
	print "</form>\n";

}elseif ($mode == "com"){

	$com = $_POST["com"];
	$ch=curl_init();
	curl_setopt ($ch,CURLOPT_URL,$urlp);
	curl_setopt ($ch,CURLOPT_POST,1);

	//postするデータ
	$post = "comment=$com&sessionid=$sid&mhs=true";

	curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_REFERER,$refurl);
	curl_setopt ($ch,CURLOPT_USERAGENT,$UA);

	$res = curl_exec($ch);
	curl_close ($ch);

	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='text' name='com'>\n";
	print "<input type='hidden' name='mode' value='com'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='発言'>\n";
	print "</form>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='mode' value='logout'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='退室'>\n";
	print "</form>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='mode' value='ref'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='リロード'>\n";
	print "</form>\n";

}elseif ($mode == "logout"){

	$ch=curl_init();
	curl_setopt ($ch,CURLOPT_URL,$urlp);
	curl_setopt ($ch,CURLOPT_POST,1);

	//postするデータ
		$post = "logout=&sessionid=$sid&mhs=true";
	curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_REFERER,$refurl);
	curl_setopt ($ch,CURLOPT_USERAGENT,$UA);

	$res = curl_exec($ch);
	curl_close ($ch);
	
	print "<h2>退室しました。</h2>\n";
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='チャットトップへ'>\n";
	return;

}else{

	$ch=curl_init();
	curl_setopt ($ch,CURLOPT_URL,$urlp);
	curl_setopt ($ch,CURLOPT_POST,1);
	
	//postするデータ
	if ($sid){
	$post = "sessionid=$sid&mhs=true";
	}else{
	$post = "";
	}
	curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_REFERER,$refurl);
	curl_setopt ($ch,CURLOPT_USERAGENT,$UA);

	$res = curl_exec($ch);
	curl_close ($ch);
	
	$siddata = json_decode($res);
	
	if ($sid){
	}else{
	$sid = $siddata->{'sessionid'};
	}
	
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='text' name='name'>\n";
	print "<input type='hidden' name='mode' value='login'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='入室'>\n";
	print "</form>\n";
	
	print "<form action='./index.php' method='POST' charset='UTF-8'>\n";
	print "<input type='hidden' name='sid' value='$sid'>\n";
	print "<input type='submit' value='リロード'>\n";
	print "</form>\n";
	
}
	
	
//ログ再取得
	$ch=curl_init();
	curl_setopt ($ch,CURLOPT_URL,$urlp);
	curl_setopt ($ch,CURLOPT_POST,1);

	//postするデータ
	$post = "sessionid=$sid";

	curl_setopt ($ch,CURLOPT_POSTFIELDS,$post);
	curl_setopt ($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
	curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
	curl_setopt ($ch,CURLOPT_REFERER,$refurl);
	curl_setopt ($ch,CURLOPT_USERAGENT,$UA);

	$res = curl_exec($ch);
	curl_close ($ch);

//JSON処理、出力
$data = json_decode($res);
$commentdata = $data->{'newcomments'};
$b = 29;
for($a = 0; $a < 25; $a++) {
$datab = ($commentdata[$b]);
print "<div>";
print $datab->{'name'};
print " > ";
print $datab->{'comment'};
$date = $datab->{'date'};
print date("(Y-m-d H:i:s)", $date);
print "</div>\n";
$b = $b - 1;
}
?>
<div><small>Mobile HighChat System for JPhone</small></div>
<div><small><small>Copyright (C) 2011 Mamesoft All Rights Reserved.</small></small></div>
</body>
</html>