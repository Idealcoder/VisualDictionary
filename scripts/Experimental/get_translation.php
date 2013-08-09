<?php
$to_lang = $_GET["to"];
$from_lang = $_GET["from"];
$text = $_GET["text"];
exec("python translation.py", $output);
$check = substr($output, 1);
if ($check=="*") {

	echo "Error"
}
else {
	echo($output);}
?>