<?
require_once('gmaps.php');
require_once('header.php');
if(!isset($_SESSION['id'])){
	$_SESSION['lat']=0;
	$_SESSION['lng']=0;
	$_SESSION['username']="";
}
	echo "<ol><li>";
	#Initialize the map
	echo "<b>Show:</b><select class='select' id='type' onChange=setState()>";
	echo "<option value='found'>Found Pets</option>";
	echo "<option value='lost'>Lost Pets</option>";
	echo "</select>";
	echo "<div id=map  class='map' style='width:400px; height:400px'></div>";
	echo "<script language='javascript'>init('".$_SESSION['lat']."','".$_SESSION['lng']."','".$_SESSION['username']."','found');</script>";
	echo "</li>";
?>
