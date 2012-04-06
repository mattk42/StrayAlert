<?php
require_once('header.php');
require_once('functions.php');

#Function to check an array of fields and set variables based off of those fields
function insert($fields,$cols,$table,$url='index.php',$value_array=Array()){
        foreach ($fields as $field){
                if(isset($_POST[$field])){
			$$field="'".mysql_real_escape_string($_POST[$field])."'";
			$value_array[]=$$field;
                }
                else{
			echo "Form Error";	
		}
        }
	$values=implode(",",$value_array);
	$columns=implode(",",$cols);
	$query="INSERT INTO ".$table."(".$columns.") VALUES(".$values.")";
        mysql_query($query) or die(mysql_error());
	header("Location: $url");	
}

#Login stuff
if(isset($_GET['l']) && $_GET['l'] == '1'){
        $username=mysql_real_escape_string($_POST['username']);
        $password=mysql_real_escape_string($_POST['password']);

        $query="SELECT id,lat,lng FROM user WHERE username='".$username."' AND hashword=SHA1('".$password."')" or die(mysql_error());
        $res = mysql_query($query) or die(mysql_error());;
        $count = mysql_num_rows($res);
        if($count == 1){
       
	         echo "Login Successfull";
                session_start();
                $row = mysql_fetch_row($res);
                $_SESSION['id']=$row[0];
                $_SESSION['username']=$username;
		$_SESSION['lat']=$row[1];
		$_SESSION['lng']=$row[2];

		mysql_query("UPDATE user SET last_login=now() WHERE id='".$_SESSION['id']."'") or die(mysql_error());

                header( "Location: $root_dir/index.php" ) ;
        }
        else{
                echo "Login Failed";
        }
}

#Logout Stuff
else if(isset($_SESSION['id']) && isset($_GET['lo']) && $_GET['lo'] == '1'){
	session_destroy();
	header( "Location: $root_dir/index.php" ) ;
}

#registration stuff
else if(isset($_GET['r']) && $_GET['r']=='1'){
        #check and escape all of the form fields
        $fields=array('username','email','phone','address','city','state','zip');
	$cols=array('lat','lng','hashword','username','email','phone','address','city','state','zip');
        
	#special check on the passwords
        if($_POST['password1'] == $_POST['password2']){
                $password=mysql_real_escape_string($_POST['password1']);
        }
        else{
                die("Passwords did not match");
        }
       
	 $loc=geoloc(mysql_real_escape_string($_POST['address']." ".$_POST['city']." ".$_POST['state']." ".$_POST['zip']));
        $value_array[]=$loc[0];
        $value_array[]=$loc[1];
	$value_array[]="'".sha1(mysql_real_escape_string($_POST['password1']))."'";

        insert($fields,$cols,'user','index.php',$value_array);

}

#add stray
else if( isset($_SESSION['id']) && isset($_GET['a']) && $_GET['a']=='1'){
	#check and escape all of the form fields
	$fields=array('address','city','state','zip','type','breed','color','approx_age','sex','image','notes');
	$cols=array('user_id','lat','lng','address','city','state','zip','type','breed','color','approx_age','sex','image','notes');	
	$value_array[]=$_SESSION['id'];	
	$loc=geoloc(mysql_real_escape_string($_POST['address']." ".$_POST['city']." ".$_POST['state']." ".$_POST['zip']));
	$value_array[]=$loc[0];
	$value_array[]=$loc[1];
	insert($fields,$cols,'stray','index.php',$value_array);
}

#add pet
else if(isset($_SESSION['id']) && isset($_GET['p']) && $_GET['p']=='1'){
	$value_array[]=$_SESSION['id'];
	$value_array[]="'Home'";
        $fields=array('name','petid','type','breed','color','birthday','sex','image','notes');
	$cols=array('user_id','state','name','petid','type','breed','color','birthday','sex','image','notes');
	insert($fields,$cols,'pet','pets.php',$value_array);
	 	
}

#edit pet
else if(isset($_SESSION['id']) && isset($_GET['e']) && $_GET['e']=='1'){
        $fields=array('name','birthday','color','notes','image','pid');
        
	foreach ($fields as $field){
                if(isset($_POST[$field])){
                        $$field="'".mysql_real_escape_string($_POST[$field])."'";
                }
                else{
                        echo "Form Error";
                }
        }

	$query="UPDATE pet SET name=".$name.",birthday=".$birthday.", color=".$color.", notes=".$notes.", image=".$image." WHERE id=".$pid." AND user_id=".$_SESSION['id'];
	mysql_query($query) or die (mysql_error());
        header("Location: $root_dir/pets.php");

}


#PM SEND
else if(isset($_SESSION['id']) && isset($_GET['s']) && $_GET['s']=='1'){
	$value_array[]=$_SESSION['id'];
	$fields=array('to_id','subject','body');
	$cols=array('from_id','to_id','subject','content');
	insert($fields,$cols,'message','messages.php?c=1',$value_array);
}	

#if nothing happened, go home
#header( "Location: $root_dir/index.php" ) ;


?>
