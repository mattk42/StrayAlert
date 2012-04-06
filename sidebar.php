<div class=sidebar align=center>
<br><br><br>
<?php
if(isset($_SESSION['username'])){

	echo "<div class=section><div class=title>Nearby Found</div>";	
	$query="SELECT breed,color,approx_age,sex,image, ( ".$EARTH_RADIUS." * acos( cos( radians(".$_SESSION['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$_SESSION['lng'].") ) + sin( radians(".$_SESSION['lat'].") ) * sin( radians( lat ) ) ) ) AS distance, type FROM stray HAVING distance < 25 ORDER BY type,distance";
	$res = mysql_query($query) or die (mysql_error());
	$type="";
	while($row = mysql_fetch_row($res)){
		if($row[6]!=$type){
			$type=$row[6];
			echo "<br><b>".$type."s</b><br>";
		}
		echo "<li>".$row[0]."[".$row[1]."]</li>";
	}
echo"<br></div><br><br><br>";
        echo "<div class=section><div class=title>Nearby Lost</div>";
        $query="SELECT breed,color,sex,image, ( ".$EARTH_RADIUS." * acos( cos( radians(".$_SESSION['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$_SESSION['lng'].") ) + sin( radians(".$_SESSION['lat'].") ) * sin( radians( lat ) ) ) ) AS distance, type FROM pet,user WHERE pet.state='Lost' and user_id=user.id HAVING distance < 25 ORDER BY type,distance";
        $res = mysql_query($query) or die (mysql_error());
        $type="";
        while($row = mysql_fetch_row($res)){
                if($row[5]!=$type){
                        $type=$row[5];
                        echo "<br><b>".$type."s</b><br>";
                }
                echo "<li>".$row[0]."[".$row[1]."]</li>";
        }

	echo "<br></div><br><br><br>";

}
?>
</div>
