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
# �K�v�ɉ����ĕύX���鍀��                                 #
############################################################

# Language (JP/EN)
# ���� (JP/EN)

$language = 'JP';

# Delay time to load new page
# �V�����y�[�W�����[�h����҂�����

$delaytime = 0;

############################################################

# Messages
# ���b�Z�[�W

%MESSAGE = (
'ENpost_method', 'POST method is disabled. Use GET method.', 
'ENurl_not_specified', 'URL is not specified.',
'ENaccessing', 'Accessing...  Wait a moment...',

'JPget_method', 'POST���\�b�h�ł̌Ăяo���͖����ł��BGET���\�b�h���g�p���Ă��������B',
'JPurl_not_specified', 'URL���w�肳��Ă��܂���B',
'JPaccessing', '���L��URL�ɃW�����v���܂��B'
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
		<title>���_�C���N�g</title>
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
<ul selected="true" id="top" title="���_�C���N�g">
<li>���L�̃T�C�g�փA�N�Z�X���悤�Ƃ��Ă��܂��B<br>
�A�N�Z�X����ꍇ��URL���^�b�v���Ă��������B</li>
<li><a href="$url" target="_self">$url</a></li>
<li><small>�X�}�[�g�t�H����81.la�`���b�g<small></li>
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
		$exit_msg = '�u���E�U��[�߂�]�{�^�����N���b�N���Ă��������B';
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
<a href="javascript:history.back();">�߂�</a>
</body>
</html>
EOF
	exit;
}
