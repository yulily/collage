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
	/*
	<?php
		function db_connect() {
			$link = mysql_connect('mysql586.phy.lolipop.jp','LAA0023626','kawamoto81');
			if (!$link) {
	 		   die('接続できませんでした: ' . mysql_error());
			}
			mysql_select_db('LAA0023626-dapad');
			mysql_query('set main set utf8');
			return $link;
		}
	?>
	*/
?>
