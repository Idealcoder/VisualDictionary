<?php
function get_picture() {
$word = $_GET["word"];
$con = mysql_connect('130.246.255.194:3306', 'YRS-2013', 'hipercritical', 'yrs-2013');
$sel = mysql_select_db("yrs-2013");
$query = "SELECT * FROM imagetag WHERE name = '$word'";
$result = mysql_query($query);
$tags = array();
$image_id = array();
while($row=mysql_fetch_array($result)) {
	$tags[] = $row["name"];
	$image_id[] = $row["imageid"];
}
echo $tags[];
echo $image_id[];
 }

get_picture();
?>