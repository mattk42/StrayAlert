<?php
require_once('header.php');
?>
<form name='register' method='POST' action='post.php?r=1'>
	<fieldset><ol>
		<legend>Account</legend>
		<li><label for='username'>Username:</labe;><input type='text' name='username' required autofocus></input><br /></li>
		<li><label for='password'>Password:</labe;><input type='password' name='password1' required></input><br /></li>
		<li><label for='password2'>Password (again):</labe;><input type='password' name='password2' required></input><br /></li>
	</ol></fieldset>
	<fieldset><ol>
		<legend>Personal</legend>
		<li><label for='email'>E-mail Address:</labe;><input type='email' name='email' required ></input><br /></li>
		<li><label for='address'>Address:</labe;><input type='text' name='address' required></input><br /></li>
		<li><label for='city'>City:</labe;><input type='text' name='city' required></input><br /></li>
		<li><label for='state'>State:</labe;><input type='text' name='state' required></input><br /></li>
		<li><label for='zip'>Zip:</labe;><input type='number' name='zip' required></input><br /></li>
		<li><label for='phone'>Phone Number:</labe;><input type='number' name='phone' required></input><br /></li>
	</ol></fieldset>
	<input type='submit'>
</form>
<?php

?>
