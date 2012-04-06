<?php
require_once('header.php');
?>

<form name='addpet' method='POST' action='post.php?p=1'>
	<fieldset><ol>
	<legend>Description</legend>
		<li><label for='name'>Name:</label><input type='text' name='name'></input></li>	
		<li><label for='petid'>Pet ID Name <input type='text' name='petid'><br>
		<div class='comment'>This is the name that will be used to look up your pet.</div></li>

		<li><label for='type'>Type:</label><select name='type'>
			<option value='Cat'>Cat</option>
			<option value='Dog'>Dog</option>
		</select></li>
		<li><label for='breed'>Breed:</label><select name='breed'
		<?php
			$query="SELECT name FROM breed ORDER BY ID ASC";
			$res = mysql_query($query);
			while($row=mysql_fetch_row($res)){
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
		?>
			</select></li>
		<li><label for='color'>	Color:</label><input type='text' name='color'></input></li>
                <li><label for='birthday'>Birthday:</label><input type='date' name='birthday'></input></li>
		<li><label for='sex'>	Gender:</label><input type='text' name='sex'></input></li>
		<li><label for='image'>	Image:</label><input type='text' name='image'></input></li>
		<li><label for='notes'> Notes:<input type='text' name='notes'></input></li>
	</ul></fieldset>
	<input class=button type='submit'>
</form>
