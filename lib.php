<?php
	function db_connect() {
		$link = mysql_connect('localhost','root','root');
		if (!$link) {
 		   die('接続できませんでした: ' . mysql_error());
		}
		mysql_select_db('white');
		mysql_query('set main set utf8');
		return $link;
	}
?>