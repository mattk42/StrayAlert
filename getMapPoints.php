<?
require_once('config.php');
mysql_connect($db['host'],$db['user'],$db['password']) or die("Failed to connect to database.");
mysql_select_db($db['name']) or die ("Failed to select database.");

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node); 

// Select all the rows in the markers table
$l1=mysql_real_escape_string($_GET['l1']);
$l2=mysql_real_escape_string($_GET['l2']);
$n1=mysql_real_escape_string($_GET['n1']);
$n2=mysql_real_escape_string($_GET['n2']);
$type=mysql_real_escape_string($_GET['type']);

if($type=='lost'){
	$table="pet,user";
	$append="AND pet.state='Lost' AND user.id=pet.user_id";
}
else{
	$table="stray";
	$append="";
}
	
$query = "SELECT * FROM ". $table ." WHERE lat BETWEEN '".$l2."' AND '".$l1."' AND lng BETWEEN '".$n2."' AND '".$n1."' ".$append;
$file = fopen('/tmp/query','w');
fwrite($file,$query);
fclose($file);

$result = mysql_query($query) or   die('Invalid query: ' . mysql_error());

header("Content-type: text/xml"); 

// Iterate through the rows, adding XML nodes for each

while ($row = @mysql_fetch_assoc($result)){  
  // ADD TO XML DOCUMENT NODE  
  $node = $dom->createElement("marker");  
  $newnode = $parnode->appendChild($node);   
  #$newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("lat", $row['lat']);  
  $newnode->setAttribute("lng", $row['lng']);  
  $newnode->setAttribute("type", $row['type']);
  $newnode->setAttribute("image", $row['image']);
  $newnode->setAttribute("notes", $row['notes']);
  $newnode->setAttribute("breed", $row['breed']);
  $newnode->setAttribute("color", $row['color']);
  $newnode->setAttribute("user_id", $row['user_id']);
} 

echo $dom->saveXML();

?>
