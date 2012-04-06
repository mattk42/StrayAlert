<?php
require_once('header.php');

#Toggle pet state
if(isset($_GET['pid'])){
	$pid = mysql_real_escape_string($_GET['pid']);
	$state='Home';
	if(isset($_GET['lost']) && $_GET['lost']==1){
		$state='Lost';
	}
	$query = "UPDATE pet SET state='".$state."' WHERE id=".$pid;
	echo $query;
	mysql_query($query) or die(mysql_error());
	header("Location: $root_dir/pets.php");
}

#PET EDIT FOR
if(isset($_GET['eid'])){
	$pid = mysql_real_escape_string($_GET['eid']);
	$query = "SELECT name,birthday,color,notes,image FROM pet WHERE id=".$pid. " AND user_id=".$_SESSION['id'];
	$res = mysql_query("$query") or die(mysql_error());
	$row=mysql_fetch_row($res);
	echo "<form name=editpet method=post action=post.php?e=1>";
	echo "<fieldset><ol>";
	echo "<input name=pid type=hidden value=".$pid."></input>";
	echo "<li><label for=name>Name:</label><input name=name type=text value=".$row[0]."></input>";
	echo "<li><label for=name>Birthday:</label><input name=birthday type=date value=".$row[1]."></input>";
	echo "<li><label for=name>Color:</label><input name=color type=text value=".$row[2]."></input>";
	echo "<li><label for=name>Notes:</label><input name=notes type=text value=".$row[3]."></input>";
	echo "<li><label for=name>Image:</label><input name=image type=text value=".$row[4]."></input>";
	echo "</ol>";
	
	echo "<input class=button type=submit>";
}
#REMOVE PET
else if(isset($_GET['did'])){
	$pid=mysql_real_escape_string($_GET['did']);
	$query="DELETE FROM pet WHERE id=".$pid." AND user_id=".$_SESSION['id'];
	mysql_query($query) or die(mysql_error());
	header("Location: $root_dir/pets.php");
}
#REMOVE STRAY 
else if(isset($_GET['dsid'])){
        $pid=mysql_real_escape_string($_GET['dsid']);
        $query="DELETE FROM stray WHERE id=".$pid." AND user_id=".$_SESSION['id'];
        mysql_query($query) or die(mysql_error());
        header("Location: $root_dir/pets.php");
}
else{
	echo "<a href='addpet.php'>Add Pet</a><br><br>";
	echo "<legend>Pets</legend>";
	$query="SELECT name,breed,birthday,color,sex,notes,image,state,id,petid FROM pet WHERE user_id=".$_SESSION['id'];
	$res = mysql_query($query) or die(mysql_error());

	while($row = mysql_fetch_row($res)){
		echo "<table><tr>";
		echo "<td><img width='200' src='".$row[6]."'></img></td>";
		echo "<td><b>Name:</b>".$row[0]."<br>";
		echo "<b>PetID:</b>".$row[9]."<br>";
		echo "<b>Breed:</b>".$row[1]."<br>";
		echo "<b>Birthday:</b>".$row[2]."<br>";
		echo "<b>Color:</b>".$row[3]."<br>";
		echo "<b>Sex:</b>".$row[4]."<br>";
		echo "<a href=?eid=".$row[8].">Edit Information</a><br>";
		echo "<a href=?did=".$row[8].">Remove Pet</a><br>";
		if ($row[7]=="Home"){
			echo "<a href=?pid=".$row[8]."&lost=1> Mark as lost</a>";
		}
		else{
			echo "<a href=?pid=".$row[8].">Mark as home.</a>";
		}
		echo "<br><br>";
		echo "</td></tr></table><br>";
	}


	echo"<br><br><br><legend>Found</legend>";
	$query="SELECT petid, breed, color, approx_age, sex, image, id FROM stray WHERE user_id=".$_SESSION['id'];
        $res = mysql_query($query) or die(mysql_error());

        while($row = mysql_fetch_row($res)){
                echo "<table><tr>";
                echo "<td><img width='200' src='".$row[5]."'></img></td>";
                echo "<td>";
		if($row[0]!=""){
			echo "<b>PetID:</b>".$row[0]."<br>";
		}
                echo "<b>Breed:</b>".$row[1]."<br>";
                echo "<b>Color:</b>".$row[2]."<br>";
                echo "<b>Approx Age:</b>".$row[3]."<br>";
                echo "<b>Sex:</b>".$row[4]."<br>";
		echo "<a href=?dsid=".$row[6].">Remove Stray</a><br>";
                echo "<br><br>";
                echo "</td></tr></table><br>";
        }

}

require_once('footer.php');
?>
