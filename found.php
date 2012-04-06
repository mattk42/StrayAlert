<?php
require_once('header.php');


if(isset($_GET['pid'])){
	$pid=mysql_real_escape_string($_GET['pid']);
	
	$query="SELECT type,breed,color,approx_age,sex,image,notes FROM stray WHERE id=$pid";
	$res = mysql_query($query);
	$row = mysql_fetch_row($res);

	echo $row[0];
	echo $row[1];
}
