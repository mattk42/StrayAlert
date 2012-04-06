<?
require_once('config.php');
echo '<link rel="stylesheet" type="text/css" href="styles.css" />';
mysql_connect($db['host'],$db['user'],$db['password']) or die("Failed to connect to database.");
mysql_select_db($db['name']) or die ("Failed to select database.");
session_start();

echo "<div class=header>";
echo "<center><div class=title>PetSecure</div></center>";
if(isset($_SESSION['id'])){
	$query="SELECT count(*) FROM message WHERE is_read=0 AND to_id=".$_SESSION['id'];
	$res = mysql_query($query) or die(mysql_error());
	$row = mysql_fetch_row($res);
	$unread=$row[0];
}
        echo "<div class=menu>
                <a href='index.php'>Home</a>
                <a href='report.php'>Report</a>";
		if(isset($_SESSION['id'])){	
                	echo "<a href='pets.php'>My Pets</a>
                		<a href='messages.php'>Messages (".$unread.")</a>
                		<a href=post.php?lo=1>Logout</a>";
		}
        echo "</div>";

if(!isset($_SESSION['id'])){?>
	<form id='login' name='login' method='POST' action='post.php?l=1'>
		<fieldset><ol>
			<input type='text' name='username' class='ti' placeholder='Username'></input>
			<input type='password' name='password' class='ti' placeholder='Password'></input>
			<input class='button' type='submit' value='Login'>
		</fieldset>
		<a href='register.php'>Register</a>
	</form>
	<?php } ?>
</div>

<?php
	echo '<div class=body align=center>';	
	require_once('sidebar.php');
	echo '<div class=content align=center>';
?>
