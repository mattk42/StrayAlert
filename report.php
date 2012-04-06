<?php
require_once('header.php');
if(isset($_GET['n'])){
?>
<form name='report' method='POST' action='post.php?a=1'>
	<fieldset><ol>
	<legend>Description</legend>
		<li><label for='type'>Type:</label><select name='type'>
			<option value='Cat'>Cat</option>
			<option value='Dog'>Dog</option>
		</select></li>
		<li><label for='breed'>Breed:</label><select name='breed'>
		<?php
			$query="SELECT name FROM breed ORDER BY ID ASC";
			$res = mysql_query($query);
			while($row=mysql_fetch_row($res)){
				echo "<option value='".$row[0]."'>".$row[0]."</option>";
			}
		?>
			</select></li>
		<li><label for='color'>	Color:</label><input type='text' name='color'></input></li>
		<li><label for='approx_age'>Approximate Age:</label><input type='number' name='approx_age'></input></li>
		<li><label for='sex'>	Gender:</label><input type='text' name='sex'></input></li>
		<li><label for='image'>	Image:</label><input type='text' name='image'></input></li>
		<li><label for='notes'> Notes:<input type='text' name='notes'></input></li>
	</ul></fieldset>
	<fieldset><ol>
	<legend>Location</legend>
		<li><label for='address'>	Address:</label><input type='text' name='address'></input></li>
		<li><label for='city'>	City:</label><input type='text' name='city'></input></li>
		<li><label for='state'>	State:</label><input type='text' name='state'></input></li>
		<li><label for='zip'>	Zip:</label><input type='text' name='zip'></input></li>
	</ul></fieldset>
	<input class='button' type='submit' value='Submit'>
</form>
<?php
}
else{?>
<form name='report' method='POST' action='lookup.php'>
        <fieldset><ol>
        <legend>Report</legend>
                <li><label for='petid'>Pet ID Name:</label><input type='text' name='petid'></input></li>
		<br><a href='?n=1'>This pet doesn't have a tag</a>
        </ul></fieldset>
        <input class='button' type='submit' value='Submit'>
</form>

<?php
}
	require_once('footer.php');
	echo "</div>";
?>
