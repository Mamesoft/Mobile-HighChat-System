<!doctype html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>数式</title>
		<link rel="stylesheet" href="http://mamesoft.jp/css/iui.css">
		<script type="text/javascript" src="http://mamesoft.jp/js/iui.js"></script>
		<meta name="viewport" id="iphone-viewport" content="width=320, user-scalable=no,maximum-scale=1">
		</head>
	<body>
	<div class="toolbar">
  <h1 id="pageTitle">81 chat</h1>
  <a id="backButton" class="button" href="#"></a>
</div>

<?php

if(isset($_GET['url'])) {
      $url = $_GET['url'];
      print("<ul selected=\"true\" id=\"top\" title=\"リダイレクト\">\n");
      print("<li>下記のサイトへアクセスしようとしています。<br>\n");
      print("アクセスする場合はURLをタップしてください。</li>\n");
      print("<li><a href=\"$url\" target=\"_self\">$url</a></li>\n");
}
elseif(isset($_GET['gyazo'])) {
      $url = $_GET['gyazo'];
      print("<ul selected=\"true\" id=\"top\" title=\"Gyazo\">\n");
      print("<li>\n");
      print("<img src=\"http://$url\">\n");
      print("</li>\n");
}
elseif(isset($_GET['math'])) {
      $url = $_GET['math'];
      print("<ul selected=\"true\" id=\"top\" title=\"数式\">\n");
      print("<li>\n");
      print("<img src=\"../mimetex.cgi?$url\">\n");
      print("</li>\n");
}
else {
      print("<ul selected=\"true\" id=\"top\" title=\"Error\">\n");
      print("<li>\n");
      print("値が指定されていません！</li>");
      print("<li><a href=\"./\" target=\"_self\">戻る</li>");
      }
?>
<li><small>Mobile HighChat System</small>
<li><small><small>Copyright (C) 2011 Mamesoft All Rights Reserved.</small></small></li>
</ul>
</body>
</html>