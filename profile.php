<?php
require_once('header.php');

if(isset($_GET['uid'])){
	$uid=mysql_real_escape_string($_GET['uid']);

	$query="SELECT username,share_email,share_pets,email,id FROM user WHERE id=$uid";
	$res=mysql_query($query);
	$row=mysql_fetch_row($res);
	echo "<b>Username:</b>$row[0]<br>";
	if($row[1]==1){
		echo "<br><b>Email:</b><a href=mailto'".$row[3]."'>".$row[3]."</a><br><br>";
	}
	echo "<a href='messages.php?send=".$uid."'>Send Private Message</a><br><br>";
	if($_SESSION['id']==$row[4]){
		echo "<a href=profile.php>Edit Profile</a><br><br>";
	}
	if($row[2]==1){
		$query="SELECT name,type,breed,birthday,color,sex,notes,image,state FROM pet WHERE user_id=$uid ORDER BY type";
		$res=mysql_query($query);
		
		$type="";
		while($row=mysql_fetch_row($res)){
			if($row[1] != $type){
				echo "<div class='title'>$row[1]s</div>";
				$type=$row[1];
			}
			echo "<table><tr>";
			echo "<td><img width='200' src='".$row[7]."'></img></td>";
			echo "<td><b>".$row[0]."</b><br>".$row[1]."<br>";
			echo "</td></table>";
		}
	}	
}
else{
	echo "<form id=profile action=post.php method=post>";
	echo "<fieldset><legend>Information</legend>";
	echo "<ol>";
	echo "<li>TEST";
	echo "</fieldset>";
	echo "<fieldset><legend>Privacy</legend>";
	echo "<ol>";
	echo "<li><label for=sp>Share Pets:<input class=select type=radio name=sp value=1>Yes<input class=select type=radio name=sp value=0>No<br>";
	echo "<li><label for=se>Share Email:<input class=select type=radio name=se value=1>Yes<input class=select type=radio name=se value=0>No<br>";
	echo "</fieldset>";
	echo "<input type=submit class=button value=Update>";
	echo "</form>";

}
