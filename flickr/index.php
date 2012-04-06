<?php
error_reporting(E_ALL);

require_once('../config.php');
mysql_connect($db['host'],$db['user'],$db['password']) or die("Failed to connect to database.");
mysql_select_db($db['name']) or die ("Failed to select database.");
require_once("phpFlickr.php");

if(isset($_GET['url'])){
	$url=mysql_real_escape_string($_GET['url']);
	$id=mysql_real_escape_string($_GET['id']);
	$query="UPDATE breed SET image='".$url."' WHERE id='".$id."'";
	mysql_query($query) or die(mysql_error());
}

$query = "SELECT name,id FROM breed WHERE image is NULL LIMIT 3";
$res = mysql_query($query) or die(mysql_error());
while($row = mysql_fetch_row($res)){
	echo "<br>";
	$breed=$row[0];
	echo $breed;
	$f = new phpFlickr("6c3e8f3123293b8360b9f59ca8b84d5b",$secret="729ea5de388054aa");
	$recent= $f->photos_search(array("tags"=>$breed,"license"=>"4"));
	echo "(".count($recent['photo'])."}<a href=?url=.&id=".$row[1].">SKIP</a><br>";
	echo $f->getErrorMsg();
	foreach ($recent['photo'] as $photo) {
	    $url="http://farm".$photo['farm'].".static.flickr.com/".$photo['server']."/".$photo['id']."_".$photo['secret']."_s.jpg";
	    echo "<a href='?url=" . $url . "&id=".$row[1]."'>";
	    echo "<img src=".$url."></img>";
	    echo "</a>";
	}
	flush();
}
?>
