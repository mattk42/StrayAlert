<?php
require_once('header.php');
if(isset($_POST['petid'])){
	$petid = mysql_real_escape_string($_POST['petid']);

	$query="SELECT state, notes, user_id FROM pet WHERE petid='".$petid."'";
	$res = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($res);
	
	$query2 = "SELECT username FROM user WHERE id='".$row[2]."'";
	$res2 = mysql_query($query2) or die(mysql_error());
	$row2 = mysql_fetch_row($res2);

	if($row[0]=='Home'){
		echo "This pet has not been reported as lost. Please check back later if you are looking for this pet's owner";
	}
	else if(mysql_num_rows($res)==0){
		echo "There is no pet using that petID";
	}
	else{
		echo "<legend> Pet ID: ".$petid."</legend>";
		echo "<legend>Owner: <a href=messages?send=".$row[2].">".$row2[0]."</a></legend>";
		echo "<ol><li><pre>".$row[1]."</pre></ol>";
		echo "Please contact this user with the provided information to return their pet safely."; 
	}
}
else{
	echo "No petid supplied.";
}
?>
