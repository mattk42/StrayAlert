<?php
require_once('header.php');
if(isset($_GET['send'])){
	$uid=mysql_real_escape_string($_GET['send']);
	$query="SELECT username FROM user WHERE id=".$uid;
	$res = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($res);
	$username = $row[0];
	echo"<form id='send' method='post' action='post.php?s=1'>";
	echo "<fieldset><ol>";
	echo"<li><label for='to'>To:</label><input type='text' name='to' value='".$username."' readonly='readonly'><br>";
	echo"<input type='hidden' name='to_id' value='".$uid."'>";
	echo"<li><label for='subject'>Subject:</label><input type='text' name='subject'><br>";
	echo"<li><textarea name='body' rows='20'></textarea><br>";
	echo "</ol>";
	echo"<input class='button' type='submit' value='send'>";
	echo"</form>";
}
else if(isset($_GET['d'])){
	$mid = mysql_real_escape_string($_GET['d']);
	$query="DELETE FROM message WHERE id=".$mid." AND to_id=".$_SESSION['id'];
	mysql_query($query) or die(mysql_error());
        header("Location: messages.php");
	
}
else if(isset($_GET['mid'])){
	$mid=mysql_real_escape_string($_GET['mid']);

	$query="UPDATE message SET is_read=1 WHERE id=".$mid;
	mysql_query($query);
	

	$query = "SELECT subject,username, date, content FROM message,user WHERE user.id=from_id AND message.id=".$mid;
	$res = mysql_query($query) or die(mydql_error());
	$row = mysql_fetch_row($res);
	echo "<b>From:</b>".$row[1]."<br>";
	echo "<b>Subject:</b>".$row[0];
	echo "<ol>";	
	echo "<li>".$row[3];
	echo "</ol>";
	echo "<a href='?r=1'>Reply</a> <a href='?d=1'>Delete</a>";

}
else{
	echo "<div class='title'>Inbox</div>";
	$query = "SELECT subject,message.id,username,date,is_read FROM message,user WHERE user.id=from_id AND to_id=".$_SESSION['id']." ORDER BY date DESC";
	$res = mysql_query($query) or die(mysql_error());
	while($row=mysql_fetch_row($res)){
		echo "<ol>";
		if($row[4]!=1){
			echo "<li><b><a href=?mid=".$row[1].">".$row[0] . "</a>-" . $row['2']." [".$row[3]."]</b>";
		}
		else{
			 echo "<li><a href=?mid=".$row[1].">".$row[0] . "</a>-" . $row['2']." [".$row[3]."]";
		}
		echo "<a href=?d=".$row[1]."><img width='20' src='del.png'></img></a></ol>";
	}

}

require_once('footer.php');
