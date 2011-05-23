#!/usr/bin/perl

# Referrer Sweeper v1.1 (Jan-05-2000)
# Copyright (c) 1999-2000 Kan-chan <kan-chan@innocent.com>
#  Web site: http://kan-chan.stbbs.net/download/
#
# This program is free software; you can redistribute it and/or 
# modify it under the terms of the GNU General Public License as 
# published by the Free Software Foundation; either version 2 of 
# the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful, 
# but WITHOUT ANY WARRANTY; without even the implied warranty of 
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the 
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public 
# License along with this program; if not, write to the Free 
# Software Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.

# Release note:
# v1.1 (Jan-05-2000)
#   Bilingual (English/Japanese) support.
#   Option for delay time.
#   Support for URLs including CGI parameters.
# v1.0 (Aug-12-1999)
#   First release.

# Usage:
# 1. Modify the perl directory written on the top of this script 
#    if it is required.
# 2. Upload files to the CGI directory and change the permission(705).  
#    If you cannot use 705, try 755.
# 3. Call refsweep.cgi 
#    e.g.  refsweep.cgi?url=http://www.yahoo.com/
#      Remove HTTP_REFERER and load http://www.yahoo.com/
#

############################################################
# Settings you may need to modify if necessary             #
# 必要に応じて変更する項目                                 #
############################################################

# Language (JP/EN)
# 言語 (JP/EN)

$language = 'JP';

# Delay time to load new page
# 新しいページをロードする待ち時間

$delaytime = 0;

############################################################

# Messages
# メッセージ

%MESSAGE = (
'ENpost_method', 'POST method is disabled. Use GET method.', 
'ENurl_not_specified', 'URL is not specified.',
'ENaccessing', 'Accessing...  Wait a moment...',

'JPget_method', 'POSTメソッドでの呼び出しは無効です。GETメソッドを使用してください。',
'JPurl_not_specified', 'URLが指定されていません。',
'JPaccessing', '下記のURLにジャンプします。'
);

############################################################

if ($ENV{'REQUEST_METHOD'} eq "POST"){
	&error('Error', $MESSAGE{$language . 'post_method'});
} else{
	$buffer = $ENV{'QUERY_STRING'};
}
$url = $buffer;
$url =~ s/^url\=(.*)/$1/;
if ($url eq ''){
	&error('Error', $MESSAGE{$language . 'url_not_specified'});
} else{
	print <<"EOF";
Content-type: text/html

<!doctype html>
<html>
	<head>
		<meta charset="Shift_JIS">
		<title>リダイレクト</title>
		<link rel="stylesheet" href="http://mamesoft.jp/css/iui.css">
		<link rel="stylesheet" href="ios.css">
		<script type="text/javascript" src="http://mamesoft.jp/js/iui.js"></script>
		<meta name="viewport" id="iphone-viewport" content="width=600, user-scalable=no,maximum-scale=1">
		</head>
	<body>
	<div class="toolbar">
  <h1 id="pageTitle">81 chat</h1>
  <a id="backButton" class="button" href="#"></a>
</div>
<ul selected="true" id="top" title="リダイレクト">
<li>下記のサイトへアクセスしようとしています。<br>
アクセスする場合はURLをタップしてください。</li>
<li><a href="$url" target="_self">$url</a></li>
<li><small>スマートフォン版81.laチャット<small></li>
</body>
</html>
EOF
}

exit;

sub error{
	if ($language eq 'EN') {
		$exit_msg = 'Click [Back] button on the browser.';
	}
	if ($language eq 'JP') {
		$exit_msg = 'ブラウザの[戻る]ボタンをクリックしてください。';
	}

	print <<"EOF";
Content-type: text/html

<html>
<head>
<title>Error</title>
</head>
$body
<h1>$_[0]</h1>
<h3>$_[1]</h3>
<br>
<a href="javascript:history.back();">戻る</a>
</body>
</html>
EOF
	exit;
}
